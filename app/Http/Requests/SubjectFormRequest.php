<?php

namespace App\Http\Requests;

use App\Actions\HandelDataBeforeSaveAction;
use App\Actions\HanedRulesValidation;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class SubjectFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->type=='admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $arr =[
            'user_id'=>'required|exists:users,id',
            'yearid'=>'required|exists:Collages_years,id',
        ];
        $arr_lang =['name:required','info:nullable'];
        $this->ValidateUserType();
        return HanedRulesValidation::handle($arr,$arr_lang);
    }
    public function attributes()
    {
        return [
            'user_id'=>__('keywords.username'),
            'year_id'=>__('keywords.year'),
            'ar_name'=>__('keywords.ar_name'),
            'en_name'=>__('keywords.en_name'),
            'ar_info'=>__('keywords.ar_info'),
            'en_info'=>__('keywords.en_info'),
        ];
    }
    public function ValidateUserType()
    {
        if(request()->filled('user_id')){
            $user = User::query()->find(request('user_id'));
            if($user->type!='admin'){
                abort(500,'user type not allowed');
            }
        }else{
            return 'user_id is not passed (required)';
        }
    }
}
