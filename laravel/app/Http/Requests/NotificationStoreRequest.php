<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'message'=>"required",
            'user_id'=>"required",
            'type'=>"required"
        ];
    }


    public function messages()
    {
        return [
            'message'=>"Message is required",
            'user_id'=>"User is required",
            'type'=>"Type is required"
        ];
    }
}
