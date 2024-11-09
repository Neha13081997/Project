<?php
use Illuminate\Support\Str as Str;
use App\Models\Upload;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

if (!function_exists('getCommonValidationRuleMsgs')) {
	function getCommonValidationRuleMsgs()
	{
		return [
            'currentpassword.required'=>'The current password is required.',
			'password.required' => 'The new password is required.',
			'password.min' => 'The new password must be at least 8 characters',
			'password.different' => 'The new password and current password must be different.',
			'password.confirmed' => 'The password confirmation does not match.',
			'password_confirmation.required' => 'The new password confirmation is required.',
			'password_confirmation.min' => 'The new password confirmation must be at least 8 characters',
			'email.required' => 'Please enter email address.',
			'email.email' => 'Email is not valid. Enter email address for example test@gmail.com',
            'email.exists' => "Please Enter Valid Registered Email!",
            'password_confirmation.same' => 'The confirm password and new password must match.',

			'password.regex' => 'The :attribute must be at least 8 characters and contain at least one uppercase character, one number, and one special character.',
			'password.regex' => 'The :attribute must be at least 8 characters and contain at least one uppercase character, one number, and one special character.',
		];
	}
}

if (!function_exists('generateRandomString')) {
	function generateRandomString($length = 20) {
		$randomString = Str::random($length);
		return $randomString;
	}
}

if (!function_exists('uploadImage')) {
	/**
	 * Upload Image.
	 *
	 * @param array $input
	 *
	 * @return array $input
	 */
	function uploadImage($directory, $file, $folder, $type="profile", $fileType="jpg",$actionType="save",$uploadId=null,$orientation=null)
	{
		
		$oldFile = null;
        if($actionType == "save"){
			$upload               		= new Upload;
			
		}else{
			$upload               		= Upload::find($uploadId);
			$oldFile = $upload->file_path;
		}
        $upload->file_path      	= $file->store($folder, 'public');
		$upload->extension      	= $file->getClientOriginalExtension();
		$upload->original_file_name = $file->getClientOriginalName();
		$upload->type 				= $type;
		$upload->file_type 			= $fileType;
		$upload->orientation 		= $orientation;
		$response             		= $directory->uploads()->save($upload);
		// dd($upload);
        // delete old file
        if ($oldFile) {
            Storage::disk('public')->delete($oldFile);
        }

		return $upload;
	}
}

if (!function_exists('generateSlug')) {

	function generateSlug($name,$tableName, $ignoreId = null)
	{
		// Convert the name to a slug
		$slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $name));

		// Ensure no multiple hyphens
		$slug = preg_replace('/-+/', '-', $slug);

		// Trim hyphens from both ends
		$slug = trim($slug, '-');

		// Ensure the slug is unique
		$originalSlug = $slug;
		$count = 1;

		$query = \DB::table($tableName)->where('slug', $slug)->whereNull('deleted_at');
		
		// Ignore the current record if updating
		if ($ignoreId) {
			$query->where('id', '!=', $ignoreId);
		}

		while ($query->exists()) {
			$slug = "{$originalSlug}-{$count}";
			$count++;
			
			// Update the query to check for the new slug
			$query = \DB::table($tableName)->where('slug', $slug)->whereNull('deleted_at');
			if ($ignoreId) {
				$query->where('id', '!=', $ignoreId);
			}
		}
		return $slug;
	}
}

if (!function_exists('dateFormat')) {
	function dateFormat($date, $format=''){
		$startDate = Carbon::parse($date);
		$formattedDate = $startDate->format($format);
		return $formattedDate;
	}
}
?>