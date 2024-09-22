<?php

namespace App\Http\Requests;

use App\Actions\HanedRulesValidation;
use Illuminate\Foundation\Http\FormRequest;

class GovernmentFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //dd(auth()->user());
        return auth()->check() && auth()->user()->type=='admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $arr =[];
       $arr_lang =['name:required','info:nullable'];
       return HanedRulesValidation::handle([],$arr_lang);
    }
    public function attributes()
    {
        return [

            'ar_name'=>__('keywords.ar_name'),
            'en_name'=>__('keywords.en_name'),
            'ar_info'=>__('keywords.ar_info'),
            'en_info'=>__('keywords.en_info'),
        ];
    }
}
