<?php

namespace App\Http\Requests;

use App\Tipos_licenca;
use App\Classes_certificado;
use Illuminate\Validation\Rule;
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
            'certificado_confirmado' => [Rule::requiredIf($logado->isAdmin() && $this->tipo_socio == "P"),'in:0,1','integer','nullable'],//se for direção e user piloto
            'licenca_confirmada' => [Rule::requiredIf($logado->isAdmin()  && $this->tipo_socio == "P"),'in:0,1','integer','nullable'],
            'aluno' => ['in:0,1',function ($attribute, $value, $fail) {
                if ($value == 1 && $this->instrutor == 1) {
                    $fail('Não pode ser Aluno e Instrutor em simultâneo');
                }
            }]
        ];
    }
}
