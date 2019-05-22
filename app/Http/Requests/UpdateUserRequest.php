<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

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
        $tipos = array('ALUNO-PPL(A)','ALUNO-PU','ATPL','CPL(A)','NEWTYPE','PPL(A)','PU');
        $classes  = array('Class 1','Class 2','LAPL','NEWCLS');

        if ( Auth::user()->id == $user->id && !Auth::user()->isAdmin() ){

            return [
                'name' => ['required','max:255','regex:/^[a-zA-ZçÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊîÎôÔûÛ ]+$/'],
                'email' => ['required','string', 'max:255', 'email', Rule::unique('users')->ignore($user->id)],
                'nome_informal' => 'required|string|max:40',
                'nif' => 'required|string|size:9|regex:/^[0-9]+$/',
                'telefone'=> ['max:20','regex:/^([\+][\d]{3}[ ])?[\d]+$/'],
                'file_foto' => 'nullable|mimes:jpeg,bmp,png,gif',
                'endereco' => 'required|string|min:1'
            ];

        }

        return [
            'num_socio' => 'required|integer|min:1|max:99999999999|'. Rule::unique('users')->ignore($user->id),
            'name' => ['required','max:255','regex:/^[a-zA-ZçÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊîÎôÔûÛ ]+$/'],
            'email' => ['required','string', 'max:255', 'email', Rule::unique('users')->ignore($user->id)],
            'nome_informal' => 'required|string|max:40',
            'nif' => 'required|integer|max:999999999|size:9',
            'telefone'=> ['max:20','regex:/^([\+][\d]{3}[ ])?[\d]+$/'],
            'sexo' => 'required|in:M,F',
            'data_nascimento' => 'required|date',
            'file_foto' => 'nullable|mimes:jpeg,bmp,png,gif',    
            'ativo' => 'required|in:0,1',
            'quota_paga' => 'required|in:0,1',
            'direcao' => 'required|in:0,1'
        ];
    }
}
//'in:ALUNO-PPL(A),ALUNO-PU,ATPL,CPL(A),NEWTYPE,PPL(A),PU'
//in:Class 1,Class 2,LAPL,NEWCLS

//'tipo_licenca' => ['nullable',Rule::in($tipos)],
//'classe_certificado' => ['nullable',Rule::in($tipos)]