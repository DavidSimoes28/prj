<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => ['required','max:255','regex:/^[a-zA-ZçÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊîÎôÔûÛ ]+$/'],
            'email' => 'required|string|email|unique:users',
            'num_socio' => 'required|integer|unique:users|min:1|max:99999999999',
            'nome_informal' => 'required|string|max:40',
            'tipo_socio' => 'required|in:P,NP,A|min:1',
            'sexo' => 'required|in:M,F',
            'data_nascimento' =>'required|before:today|date',
            'file_foto' => 'nullable|mimes:jpeg,bmp,png,gif',
            'ativo' => 'required|in:0,1',
            'nif' => 'required|string|size:9|regex:/^[1-9][0-9]+$/',
            'telefone'=>['max:20','regex:/^([\+][\d]{3}[ ])?[\d]+$/'],
            'quota_paga'=>'required|in:0,1',
            'direcao'=>'required|in:0,1',
            'endereco'=>'required|min:1|max:250|nullable'
        ];
    }
}
