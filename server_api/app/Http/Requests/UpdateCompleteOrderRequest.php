<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompleteOrderRequest extends FormRequest
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
            'completed' => 'required|boolean',
        ];
    }

    public function messages(){
        return [

            'completed.required' => "You have to provide a completed",
            'completed.boolean' => "Insert a valid boolean"
            
        ];
    }
}
