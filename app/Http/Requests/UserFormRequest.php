<?php

namespace App\Http\Requests;
use illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
//use Psy\Util\Str;

class UserFormRequest extends FormRequest
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
        //v1//api/register
        if(Str::contains(request()->getRequestUri(),'login')){
            return [
                'email' => 'required',
                'password' => 'required',
            ];
        }
        return [
            'username' => 'required',
            'email' => 'required|unique:users,email',
            'phone' => 'required',
            'password' => 'filled', // pass if not sent
            'type' => 'required',
        ];
    }
    public function attributes()
    {
        return [
            'username' => __('keywords.username'),
            'email' => __('keywords.email'),
            'password' => __('keywords.password'),
            'phone' => __('keywords.phone'),
            'type' => __('keywords.type'),
    ];
    }
    public function messages(){
        return [
            'username.required' => __('keywords.error_msg'),
        ];
    }
}
