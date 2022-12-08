<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateProductRequest extends FormRequest
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
            'name' => 'required|string|unique',
            'type' => 'required|in:hot dish,cold dish,drink,dessert',
            'description' =>'required|string',
            'photo_url' =>'required|string',
            'price' =>'required|decimal|min:0',
            'custom' =>'nullable|json',
        ];
    }
}
