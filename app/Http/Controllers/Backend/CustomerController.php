<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CustomerDataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CustomerDataTables $dataTable)
    {
        abort_if(Gate::denies('customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $roles = Role::where('name', '!=', 'Admin')->get();
            return $dataTable->render('backend.customer.index',compact('roles'));
        } catch (\Exception $e) {
            return abort(500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('customer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = Role::where('name', '!=', 'Admin')->get();
        return view('backend.customer.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        // dd($request->all());
        abort_if(Gate::denies('customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            DB::beginTransaction();
            $customer = new User();
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->password = generateRandomString(10);
            $customer->phone = $request->phone;
            $customer->email_verified_at = date('Y-m-d H:i:s');
            $customer->created_by = 1;     
            $customer->status = 1;  
            $customer->save();
            // dd($customer);
            $role = Role::where('id', $request->role)->first();
            if ($role) {
                User::findOrFail($customer->id)->roles()->sync($role->id);
            }

            DB::commit();
          
            return response()->json([
                'success'    => true,
                'message'    => 'Customer '.trans('messages.crud.add_record'),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage().' '.$e->getFile().' '.$e->getLine());
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('customer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user = User::with('roles')->find($id);
        if($user){
            $roles = Role::where('name', '!=', 'Admin')->get();
            return view('backend.customer.edit',compact('user','roles'));
        }

        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('customer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            DB::beginTransaction();

            // $slug = generateSlug($request->name,'services');

            $customer = User::find($id);
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->status = $request->status;
        
            $customer->save();
            $role = Role::where('id', $request->role)->first();
            if ($role) {
                User::findOrFail($customer->id)->roles()->sync($role->id);
            }
            DB::commit();
          
            return response()->json([
                'success'    => true,
                'message'    => 'Customer '.trans('messages.crud.update_record'),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage().' '.$e->getFile().' '.$e->getLine());
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        abort_if(Gate::denies('customer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $user = User::where('id', $id)->first();

            DB::beginTransaction();
            try {

                $user->delete();
                
                DB::commit();
                $response = [
                    'success'    => true,
                    'message'    => 'User '.trans('messages.crud.delete_record'),
                ];
                return response()->json($response);

            } catch (\Exception $e) {
                DB::rollBack();                
                return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
            }
        }
        return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
    }

    
}
