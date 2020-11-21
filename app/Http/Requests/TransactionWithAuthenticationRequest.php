<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionWithAuthenticationRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'value' => 'required|regex:/^\d+([.]\d{1,2})?$/',
            'payee' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'regex' => 'Informe o valor no seguinte formato 1000.00',
            'required' => 'O campo :attribute é obrigatório.',
            'integer' => 'É necessário informar o campo :attribute com o código do usuário. O valor informado foi :input'
        ];
    }
}
