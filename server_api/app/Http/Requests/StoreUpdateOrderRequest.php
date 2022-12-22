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
            'ticket,number.integer' => "Insert a valid integer",
            'ticket,number.min' => "The ticket,number must be at least 0",
            'ticket,number.max' => "The ticket,number must be in max 99",

            'status.required' => "You have to provide the order status",
            'status.in' => "The payment type needs to be 'P', 'R', 'D' or 'C' "

            'customer_id.required' => "You have to provide your customer_id",
            'customer_id.exists' => "Insert a valid users id",

            'total_price.required' => "You have to provide a total_price",
            'total_price.numeric' => "Insert a valid numeric",
            'total_price.min' => "The total_price must be at least 0",

            'total_paid.required' => "You have to provide a total_paid",
            'total_paid.numeric' => "Insert a valid numeric",
            'total_paid.min' => "The total_paid must be at least 0",

            'total_paid_with_points.required' => "You have to provide a total_paid_with_points",
            'total_paid_with_points.numeric' => "Insert a valid numeric",
            'total_paid_with_points.min' => "The total_paid_with_points must be at least 0",

            'points_gained.required' => "You have to provide a points_gained",
            'points_gained.integer' => "Insert a valid integer",
            'points_gained.min' => "The points_gained must be at least 0",

            'payment_type.required' => "You have to provide the order payment_type",
            'payment_type.in' => "The payment type needs to be 'VISA', 'PAYPAL' or 'MBWAY'"

            'date.required' => "You have to provide date",
            'date.date' => "Insert a valid date",

            'delivered_by.required' => "You have to provide your delivered_by",
            'delivered_by.exists' => "Insert a valid users id"
            
        ];
    }
}
