<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
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
        /*$batota = 'in:0,1'
        if(Auth::user()->isPiloto() || Auth::user()->isAdmin()){
        if($this->instrutor == 1 && $this->aluno == 1){
            $batota = 'in:0';
        }}*/
        return [
            'name' => ['required','max:255','regex:/^[a-zA-ZçÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊîÎôÔûÛ ]+$/'],
            'email' => 'required|string|email|unique:users',
            'num_socio' => 'required|unique:users|integer|max:9999999999|min:0',
            'nome_informal' => 'required|string|max:40',
            'tipo_socio' => 'required|string|min:1|in:P,NP,A',
            'sexo' => 'required|min:1|in:M,F',
            'data_nascimento' =>'required|date|before:today',
            'file_foto' => 'nullable|mimes:jpeg,bmp,png,gif',
            'ativo' => 'required|in:0,1',
            'nif' => 'required|string|size:9|regex:/^[1-9][0-9]+$/',
            'telefone'=>['max:20','regex:/^([\+][\d]{3}[ ])?[\d]+$/'],
            'quota_paga'=>'required|in:0,1',
            'direcao'=>'required|in:0,1',
            'endereco'=>'required|min:1|max:250|nullable',
            'instrutor' => 'in:0,1',
            'aluno' => 'in:0,1'
        ];
    }
}
