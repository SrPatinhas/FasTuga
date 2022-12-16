<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|min:3|max:255|regex:/^(?![\s.]+$)[a-zA-Z\s.]*$/',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:4',
            'password_confirmation' => 'required','same:password',

            'type' => 'required|in:EC,ED,EM',

            'photo_file' => 'nullable|file|image'
        ];
    }

    public function messages(){
        return [
            'name.required' => "You have to provide a name",
            'name.min' => "The name must be at least 3 characters",
            'name.max' => "The name must be in max 255 characters",
            'name.regex' => "The name can only contain letters and spaces",

            'email.required' => "You have to provide your email",
            'email.email' => "Provide a valid email",
            'email.unique' => "This email is already in use",

            'password.required' => "You have to provide your password",
            'password.confirmed' => "Passwords do not match",
            'password.min' => "Password needs to be at least 4 characters",

            'type.required' => "You have to provide the user type",
            'type.in' => "The payment type needs to be 'EC', 'ED' or 'EM'"
        ];
    }
}
