<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Post;
use App\Rules\NoMultipleSpacesRule;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [];
        if($this->step_no == 1){
           
            $rules['title']          = ['required', 'regex:/^[a-zA-Z\s]+$/','string',  new NoMultipleSpacesRule, Rule::unique('posts', 'title')->ignore($this->post_id, 'id')->whereNull('deleted_at')];
        
            $rules['sub_title']            = ['nullable', 'string',  new NoMultipleSpacesRule];

            $rules['post_image']          = ['nullable', 'image', 'max:'.config('constant.profile_max_size'), 'mimes:jpeg,png,jpg'];
        }

        if($this->step_no == 2){
            $rules['description']           = ['nullable'];
        }

        if($this->step_no == 3){
            $rules['city']          = ['required'];
            $rules['street']        = ['nullable'];
            $rules['country']       = ['required'];
        }

        return $rules;
    }
}
