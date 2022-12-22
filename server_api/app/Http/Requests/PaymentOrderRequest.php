<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentOrderRequest extends FormRequest
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
            'notes' => 'nullable',
            'items' => 'required|array',

            'items.*.id' => 'required|numeric',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer',
            //'items.*.totalPrice' => 'required|numeric',

            'checkout.email'            => 'required|email',
            'checkout.name'             => 'required',
            'checkout.phone'            => 'required|between:9,13',
            'checkout.nif'              => 'between:8,9', // required|
            'checkout.pay_type'         => 'required|in:visa,mbway,paypal',
            'checkout.pay_reference'    => 'required',
            'checkout.points'           => 'min:0',
        ];
    }


    public function messages(){
        return [
            'customer_id.required' => "You have to provide your customer_id",
            'customer_id.numeric' => "Cutomer Id have to be a number",

            'total_price.required' => "You have to provide a total price",
            'total_price.numeric' => "Total price needs to be numeric",

            'items.required' => "You have to provide items",
            'items.array' => "Items have to be an array",

            'items.*.id.required' => "The product needs an id",
            'items.*.id.numeric' => "The product id needs to be a number",

            'items.*.price.required' => "The product needs a price",
            'items.*.price.numeric' => "The product price needs to be a number",

            'items.*.quantity.required' => "The product needs a quantity",
            'items.*.quantity.integer' => "The product quantity needs to be an integer",

            //'items.*.totalPrice.required' => "The product needs a price",
            //'items.*.totalPrice.numeric' => "The product price needs to be a number",


            'checkout.email.required' => "You have to provide your email",
            'checkout.email.email' => "Provide a valid email",

            'checkout.phone.required' => "You have to provide your phone",
            'checkout.phone.between' => "Insert a valid phone number",

            'checkout.nif.size' => "A NIF consists of 9 numbers",

            'checkout.pay_type.required' => "You have to provide your payment type",
            'checkout.pay_type.in' => "The payment type needs to be 'visa', 'mbway' or 'paypal'",

            'checkout.pay_reference.required' => "You have to provide your payment reference",

            'checkout.points.min' => "You need to send the minimum of 0 points"
        ];
    }
}
