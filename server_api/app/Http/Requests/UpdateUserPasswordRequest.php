<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateUserPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'oldpassword' => 'current_password:api',
            'password' => ['required', 'confirmed', Password::min(4)],
            'password_confirmation' => ['required','same:password'],
        ];
    }

    public function messages(){
        return [
            'password.required' => "You have to provide your password",
            'password.confirmed' => "Passwords do not match",

            'password_confirmation.required' => "You have to provide your password",
            'password_confirmation.same' => "Is the same password",
        ];
    }
    
}
