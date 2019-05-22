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
        $logado = Auth::user();

        $tipos = array('ALUNO-PPL(A)','ALUNO-PU','ATPL','CPL(A)','NEWTYPE','PPL(A)','PU');
        $classes  = array('Class 1','Class 2','LAPL','NEWCLS');
        
        $resultado = array();
        $aux = array();

        $resultado = [
                    'name' => ['required','max:255','regex:/^[a-zA-ZçÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊîÎôÔûÛ ]+$/'],
                    'email' => ['required','string', 'max:255', 'email', Rule::unique('users')->ignore($user->id)],
                    'nome_informal' => 'required|string|max:40',
                    'nif' => 'required|string|size:9|regex:/^[1-9][0-9]+$/',
                    'telefone'=> ['max:20','regex:/^([\+][\d]{3}[ ])?[\d]+$/'],
                    'file_foto' => 'nullable|mimes:jpeg,bmp,png,gif',
                    'endereco'=> 'string|max:255|nullable'
        ];

        if ( $user->isPiloto() ){
            $aux = [
                'file_certificado' => 'mimes:pdf',
                'num_certificado' => 'required|integer|max:30',
                'validade_certificado' => 'date|nullable',
                'classe_certificado' => 'nullable|in:'. implode(',', $classes),
                'file_licenca' => 'mimes:pdf',
                'num_licenca' => 'required|integer|max:30',
                'validade_licenca' => 'date|nullable',
                'tipo_licenca' => 'nullable|in:' . implode(',', $tipos),
                'instrutor' => 'required|in:0,1'
            ];

            $resultado = array_merge($resultado, $aux);
        }

        if ( $logado->isAdmin() ){
            $aux = [
                'ativo' => 'required|in:0,1',
                'quota_paga' => 'required|in:0,1',
                'direcao' => 'required|in:0,1'
            ];

            $resultado = array_merge($resultado, $aux);

            if ( $user->isPiloto() ){
                $aux = [
                    'certificado_confirmado' => 'required|in:0,1',
                    'licenca_confirmada' => 'required|in:0,1'
                ];
    
                $resultado = array_merge($resultado, $aux);
            }


        }

        //fica a faltar a alterar o campo instrutor

        dd ($resultado);

        return $resultado;
    }
}
//'in:ALUNO-PPL(A),ALUNO-PU,ATPL,CPL(A),NEWTYPE,PPL(A),PU'
//in:Class 1,Class 2,LAPL,NEWCLS

//'tipo_licenca' => ['nullable',Rule::in($tipos)],
//'classe_certificado' => ['nullable',Rule::in($tipos)]



/* US - 15
'file_certificado' => 'mimes:pdf',
'num_certificado' => 'max:30',
'validade_certificado' => 'date|nullable',
'file_licenca' => 'mimes:pdf',
'instrutor' => 'max:1',
'num_licenca' => 'max:30',
'validade_licenca' => 'date|nullable',   
'ativo' => 'nullable|in:0,1',
'quota_paga' => 'nullable|in:0,1',
'direcao' => 'nullable|in:0,1',
'tipo_licenca' => 'nullable|in:' . implode(',', $tipos),
'classe_certificado' => 'nullable|in:'. implode(',', $classes)

,   
                'ativo' => 'nullable|in:0,1',
                'quota_paga' => 'nullable|in:0,1',
                'direcao' => 'nullable|in:0,1',
                                'instrutor' => 'max:1',
*/