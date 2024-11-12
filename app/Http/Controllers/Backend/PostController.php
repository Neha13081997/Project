<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\PostDatatables;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PostDatatables $dataTable)
    {
        abort_if(Gate::denies('post_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return $dataTable->render('backend.post.index');
        } catch (\Exception $e) {
            return abort(500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('post_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        abort_if(Gate::denies('post_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            DB::beginTransaction();

            $post_id = '';

            $step_no = $request->step_no;

            $flag = false;

            switch ($step_no) {
                case 1:

                    $user = auth()->user();

                    if ($user) {

                        $user_id = $user->id;

                        $postRecords = [
                            'user_id'        => $user_id,
                            'title'          => $request->title ?? null,
                            'slug'           => $request->title ? generateSlug($request->title, 'posts') : null,
                            'sub_title'      => $request->sub_title ?? null,
                            'status'         => 1,
                        ];

                        $createdPost = Post::create($postRecords);

                        if ($createdPost) {
                            if ($request->has('post_image')) {
                                $uploadId = null;
                                $actionType = 'save';
                                uploadImage($createdPost, $request->post_image, 'post/image', "post_image", 'original', $actionType, $uploadId);
                            }
                            $post_id = $createdPost->id;
                            $flag = true;
                        }
                    }

                    break;

                case 2:

                    $findPost = Post::where('id', $request->post_id)->first();
                    // dd($request->all());
                    if ($findPost) {
                        $post_id = $findPost->id;
                        $findPost->where('id',$post_id)->update(['description' => $request->description]);
                        $flag = true;
                    }
                    break;

                case 3:

                    $findPost = Post::where('id', $request->post_id)->first();
                    if ($findPost) {
                        $post_id = $findPost->id;
                        $findPost->where('id',$post_id)->update([
                            'city' => $request->city,
                            'street' => $request->street,
                            'country' => $request->country,
                        ]);

                        $flag = true;
                    }
                    break;

                case 4:
                    $flag = true;
                    break;
                default:
                    $flag = false;
                    break;
            }

            if ($flag) {
                DB::commit();

                $message = 'Post ' . trans('messages.crud.add_record');
                if ($step_no != 1) {
                    $message = 'Post ' . trans('messages.crud.update_record');
                }

                return response()->json([
                    'success'    => true,
                    'nextStep'   => (int)$request->step_no + 1,
                    'post_id'  => $post_id,
                    'message'    => $message,
                ]);
            } else {
                return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('post_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $post = Post::where('id', $id)->first();
        if ($post) {
            return view('backend.post.show', compact('post'));
        } else {
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('post_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $post = Post::where('id', $id)->first();
        if ($post) {
            $post_id = $post->id;
            return view('backend.post.edit', compact('post','post_id'));
        } else {
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $post_id)
    {
        abort_if(Gate::denies('post_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            DB::beginTransaction();
            $post_id = $post_id;

            $step_no = $request->step_no;

            $flag = false;

            switch ($step_no) {
                case 1:

                    $postRecord = [
                        'title'       => $request->title ? ucwords($request->title) : null,
                        'slug'        => $request->title ? generateSlug($request->title, 'posts', $post_id) : null,
                        'sub_title'   => $request->sub_title ?? null,
                        'status'     => 1,
                    ];

                    $post = Post::where('id', $post_id)->first();
                    $updatedPost = $post->update($postRecord);
                    $updatedPost = $post->refresh();
                    if ($updatedPost) {
                        if ($request->has('post_image')) {
                            $uploadId = $post->post_image ? $post->post_image->id : null;
                            $actionType = $uploadId ? 'update' : 'save';
                            uploadImage($updatedPost, $request->post_image, 'post/image', "post_image", 'original', $actionType, $uploadId);
                        }
                        $flag = true;
                    }

                    break;

                case 2:

                    $post = Post::where('id', $request->post_id)->first();
                    if ($post) {
                        $post->update(['description' => $request->description]);
                        $flag = true;
                    }

                    break;

                case 3:

                    $post = Post::where('id', $request->post_id)->first();
                    if ($post) {
                        $post->update([
                            'city' => $request->city,
                            'street' => $request->street,
                            'country' => $request->country,
                        ]);
                        $flag = true;
                    }
                    break;

                case 4:

                    $flag = true;

                    break;
                default:
                    $flag = false;
                    break;
            }


            if ($flag) {
                DB::commit();

                $message = 'Post ' . trans('messages.crud.update_record');

                return response()->json([
                    'success'    => true,
                    'nextStep'   => (int)$request->step_no + 1,
                    'post_id'  => $post_id,
                    'message'    => $message,
                ]);
            } else {
                return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e->getMessage().' '.$e->getFile().' '.$e->getLine());
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        abort_if(Gate::denies('post_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $post = Post::where('id',$id)->first();

            DB::beginTransaction();
            try {

                $post->delete();
                
                DB::commit();
                $response = [
                    'success'    => true,
                    'message'    => 'Post '.trans('messages.crud.delete_record'),
                ];
                return response()->json($response);

            } catch (\Exception $e) {
                DB::rollBack();                
                return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
            }
        }
        return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
    }

    public function stepForms(Request $request, $step_no)
    {
        // dd($request->all());
        try {
            $post = Post::where('id',$request->post_id)->first();  
            if($post){
                // dd('hello');
                $html = view('backend.post.form.step_'.$step_no,compact('post'))->render();
            }
            else{
            $html = view('backend.post.form.step_' . $step_no)->render();
            }
            return response()->json(['html' => $html]);
        } catch (\Exception $e) {
            dd($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());
            return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400);
        }
    }
}
