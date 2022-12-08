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
}
