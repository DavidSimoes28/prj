<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $user = $this->route('user');
        return [
            'name' => ['max:255','regex:/^[a-zA-ZçÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊîÎôÔûÛ ]+$/'],
            'email' => ['string', 'max:255', 'email', Rule::unique('users')->ignore($user->id)],
            'nome_informal' => 'string|max:40',
            'nif' => 'max:9',
            'telefone'=> ['max:20','regex:/^([\+][\d]{3}[ ])?[\d]+$/'],
            'endereco'=> 'string',
            'data_nascimento' => 'date',
            'foto_url' => 'mimes:jpeg,bmp,png,gif',
            'certificado_pdf' => 'mimes:pdf',
            'num_certificado' => 'max:9',
            'validade_certificado' => 'date',
            'licenca_pdf' => 'mimes:pdf',
            'instrutor' => 'max:9',
            'num_licenca' => 'max:9',
            'validade_licenca' => 'date'
        ];
    }
}
