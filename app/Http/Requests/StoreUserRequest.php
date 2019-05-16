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
            'name' => ['required','max:255','regex:/^[A-Za-zçÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊîÎôÔûÛ ]+$/'],
            'email' => 'required|string|email|unique:users',
            'num_socio' => 'required|integer|unique:users',
            'nome_informal' => 'required|string|max:40',
            'tipo_socio' => 'required|in:P,NP,A',
            'sexo' => 'required|in:M,F',
            'data_nascimento' =>'required|date',
            'file_foto' => 'mimes:jpeg,bmp,png,gif',
            'ativo' => 'required|in:0,1'
        ];
    }
}
