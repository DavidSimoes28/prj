<?php

namespace App\Http\Requests;

use App\User;
use App\Tipos_licenca;
use App\Classes_certificado;
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

        $classes = Classes_certificado::all()->toArray();
        $tipos = Tipos_licenca::all()->toArray();

        $classes2 = array();
        $tipos2 = array();


        for ($i = 0; $i < count ($classes); $i++ ){
            $classes2[] = $classes[$i]['code'];
        }

        for ($i = 0; $i < count ($tipos); $i++ ){
            $tipos2[] = $tipos[$i]['code'];
        }

        //dd($tipos2);
        //dd($classes);
        
        $resultado = array();
        $aux = array();

        $resultado = [
                    'num_socio' => 'required|unique:users|integer|max:11|regex:/^[0-9][0-9]+$/',
                    'name' => ['required','max:255','regex:/^[a-zA-ZçÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊîÎôÔûÛ ]+$/'],
                    'email' => ['required','string', 'max:255', 'email', Rule::unique('users')->ignore($user->id)],
                    'data_nascimento' =>'required|date|before:today',
                    'nome_informal' => 'required|string|max:40',
                    'nif' => 'size:9|regex:/^[1-9][0-9]{8}+$/',
                    'telefone'=> ['max:20','regex:/^([\+][\d]{3}[ ])?[\d]+$/'],
                    'file_foto' => 'nullable|mimes:jpeg,bmp,png,gif',
                    'endereco'=> 'string|max:255|nullable',
                    'sexo'=>'required|in:M,F',
                    'tipo_socio' => 'required|string|min:1|in:P,NP,A'
        ];

        if ( $user->isPiloto() ){
            $aux = [
                'file_certificado' => 'mimes:pdf',
                'num_certificado' => 'nullable|string|max:30',
                'validade_certificado' => 'date|nullable',
                'classe_certificado' => 'nullable|in:'. implode(',', $classes2),
                'file_licenca' => 'mimes:pdf',
                'num_licenca' => 'nullable|string|max:30',
                'validade_licenca' => 'date|nullable',
                'tipo_licenca' => 'nullable|in:' . implode(',',  $tipos2),
                'instrutor' => 'in:0,1'
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
                    'certificado_confirmado' => 'required|integer|in:0,1',
                    'licenca_confirmada' => 'required|integer|in:0,1'
                ];
    
                $resultado = array_merge($resultado, $aux);
            }


        }

        //$teste = User::all();
        //$teste = Classes_certificado::all();
        //$teste = Tipos_licenca::all();
        //dd($resultado);


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