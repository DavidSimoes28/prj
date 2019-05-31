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
        
        $resultado = array();
        $aux = array();

        $resultado = [
            'num_socio' => ['required','integer','max:99999999999','min:1','unique:users,num_socio,'.$user->id],//se for normal
            'name' => ['required','max:255','regex:/^[a-zA-ZçÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊîÎôÔûÛ ]+$/'],
            'email' => ['required','string', 'max:255', 'email','unique:users,email,'.$user->id],
            'data_nascimento' =>'required|date|date_format:Y-m-d|before:today',
            'nome_informal' => 'required|string|max:40',
            'nif' => 'size:9|regex:/^[1-9][0-9]{8}+$/',
            'telefone'=> ['max:20','regex:/^([\+][\d]{3}[ ])?[\d]+$/'],
            'file_foto' => 'nullable|mimes:jpeg,bmp,png,gif',
            'endereco'=> 'string|max:255|nullable',
            'sexo'=>'required|in:M,F',
            'tipo_socio' => 'required|string|min:1|in:P,NP,A',
                'file_certificado' => 'mimes:pdf',//se for piloto
                'num_certificado' => 'string|max:30|nullable',
                'validade_certificado' => 'date|date_format:Y-m-d|nullable',
                'classe_certificado' => 'nullable|in:'. implode(',', $classes2),
                'file_licenca' => 'mimes:pdf',
                'num_licenca' => 'string|max:30|nullable',
                'validade_licenca' => 'date|date_format:Y-m-d|nullable',
                'tipo_licenca' => 'nullable|in:' . implode(',',  $tipos2),
                'instrutor' => ['in:0,1',function ($attribute, $value, $fail) {
                    if ($value == 1 && $this->aluno == 1) {
                        $fail('Não pode ser Aluno e Instrutor em simultânio');
                    }
                }],
            'ativo' => [Rule::requiredIf($logado->isAdmin()),'in:0,1'],//se for direção
            'quota_paga' => [Rule::requiredIf($logado->isAdmin()),'in:0,1'],
            'direcao' => [Rule::requiredIf($logado->isAdmin()),'in:0,1'],
            'certificado_confirmado' => [Rule::requiredIf($logado->isAdmin() && $user->isPiloto()),'in:0,1','integer','nullable'],//se for direção e user piloto
            'licenca_confirmada' => [Rule::requiredIf($logado->isAdmin()  && $user->isPiloto()),'in:0,1','integer','nullable'],
            'aluno' => ['in:0,1',function ($attribute, $value, $fail) {
                if ($value == 1 && $this->instrutor == 1) {
                    $fail('Não pode ser Aluno e Instrutor em simultânio');
                }
            }]
        ];

        return $resultado;
    }
}

/*
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
        
        $resultado = array();
        $aux = array();

        $resultado = [
            'num_socio' => ['required','integer','max:99999999999','min:1','unique:users,num_socio,'.$user->id],
            'name' => ['required','max:255','regex:/^[a-zA-ZçÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊîÎôÔûÛ ]+$/'],
            'email' => ['required','string', 'max:255', 'email','unique:users,email,'.$user->id],
            'data_nascimento' =>'required|date|date_format:Y-m-d|before:today',
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
                'num_certificado' => 'string|max:30|nullable',
                'validade_certificado' => 'date|nullable',
                'classe_certificado' => 'nullable|in:'. implode(',', $classes2),
                'file_licenca' => 'mimes:pdf',
                'num_licenca' => 'string|max:30|nullable',
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
                'direcao' => 'required|in:0,1',
            ];

            $resultado = array_merge($resultado, $aux);

            if ( $user->isPiloto() ){
                $aux = [
                   'certificado_confirmado' => 'integer|in:0,1|nullable',
                   'licenca_confirmada' => 'integer|in:0,1|nullable'
                ];
    
                $resultado = array_merge($resultado, $aux);
            }
        }
        return $resultado;
    }
*/