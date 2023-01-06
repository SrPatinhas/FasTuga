<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'name' => ['required', 'min:3', 'max:255'],//, 'regex:/^(?![\s.]+$)[a-zA-Z\s.]*$/'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:4'],
            'password_confirmation' => ['required','same:password'],

            'phone' => ['required', 'between:9,13'],
            'nif' => ['nullable','between:8,9'],
            'photo' => ['nullable','file','image'],

            'pay_type' => ['required', 'in:visa,mbway,paypal'],
            'pay_reference' => ['required'],
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

            'phone.required' => "You have to provide your phone",
            'phone.between' => "Insert a valid phone number",

            'nif.size' => "A NIF consists of 9 numbers",

            'pay_type.required' => "You have to provide your default payment type",
            'pay_type.in' => "The payment type needs to be 'visa', 'mbway' or 'paypal'",

            'pay_reference.required' => "You have to provide your default payment reference"
        ];
    }
}
