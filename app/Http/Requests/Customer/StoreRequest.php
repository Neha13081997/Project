<?php

namespace App\Http\Requests\Customer;

use App\Rules\NoMultipleSpacesRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
        return [
            'name' => ['required','string','max:255', new NoMultipleSpacesRule,],
            'email' => ['required','email','string', 'max:255', Rule::unique('users')->whereNull('deleted_at')],
            'phone' => ['nullable', 'numeric', 'regex:/^[0-9]{7,15}$/', Rule::unique('users', 'phone')->whereNull('deleted_at')],
            'role' => ['required','exists:roles,id'],
        ];
    }
}
