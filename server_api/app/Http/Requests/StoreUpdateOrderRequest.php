<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateOrderRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'ticket,number' => 'required|integer|min:0|max:99',
            'status' => 'required|in:P,R,D,C',
            'customer_id' => 'required|exists:customers,id',
            'total_price' => 'nullable|numeric|min:0'
            'total_paid' => 'nullable|numeric|min:0'
            'total_paid_with_points' => 'nullable|numeric|min:0'
            'points_gained' => 'required|integer|min:0'
            'payment_type' => 'required|in:VISA,PAYPAL,MBWAY',
            'payment_reference' => 'nullable|string'
            'date' => 'required|date'
            'delivered_by' => 'required|exists:users,id',
            'custom' => 'nullable|json'
        ];
    }

    public function messages(){
        return [
            'ticket,number.required' => "You have to provide a ticket,number",
            'ticket,number.min' => "The ticket,number must be at least 0",
            'ticket,number.max' => "The ticket,number must be in max 99",

            'status.required' => "You have to provide the order status",
            'status.in' => "The payment type needs to be 'P', 'R', 'D' or 'C' "

            'customer_id.required' => "You have to provide your customer_id",
            'customer_id.numeric' => "Cutomer Id have to be a number",

            'total_price.required' => "You have to provide a ticket,number",
            'total_price.email' => "The ticket,number must be at least 0",


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
