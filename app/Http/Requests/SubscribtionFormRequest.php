<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscribtionFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->type !='student';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

           'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'price'=>'required|numeric|min:0',
            'discount'=>'filled|numeric',
            'is_locked'=>'filled|numeric',
            'note'=>'nullable|string',
        ];
    }
}
