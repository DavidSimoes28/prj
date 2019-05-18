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
            'endereco'=> 'string|max:255|nullable',
            'data_nascimento' => 'date',
            'file_foto' => 'mimes:jpeg,bmp,png,gif',
            'file_certificado' => 'mimes:pdf',
            'num_certificado' => 'max:30',
            'validade_certificado' => 'date|nullable',
            'file_licenca' => 'mimes:pdf',
            'instrutor' => 'max:1',
            'num_licenca' => 'max:30',
            'validade_licenca' => 'date|nullable',
            'ativo' => 'nullable|in:0,1',
            'quota_paga' => 'nullable|in:0,1',
            'direcao' => 'nullable|in:0,1'
        ];
    }
}
