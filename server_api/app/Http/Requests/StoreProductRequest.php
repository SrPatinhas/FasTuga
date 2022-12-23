<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string',
            'type' => 'required|in:hot_dish,cold_dish,drink,dessert',
            'description' =>'required|string',
            'photo' => 'required|file|image',
            'price' =>'required|numeric|min:0',
            'custom' =>'nullable|json',
        ];
    }

    public function messages(){
        return [
            'name.required' => "You have to provide a name",
            'name.string' => "Insert a valid string",

            'type.required' => "You have to provide the order status",
            'type.in' => "The type needs to be 'hot_dish','cold_dish','drink' or 'dessert'",

            'description.required' => "You have to provide a description",
            'description.string' => "Insert a valid string",

            'photo.required' => "You have to provide a photo",

            'price.required' => "You have to provide a price",
            'price.numeric' => "Insert a valid numeric",
            'price.min' => "The price must be at least 0"

        ];
    }
}
