<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreMovimentoRequest extends FormRequest
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
        $is_piloto_aux='';
        $tipo_instrucao_aux = 'in:D,S';
        $instrutor_id_aux = '';
        $isPiloto = true;
        $logado = Auth::user();

        if($this->natureza=='I'){
        
            $instrutor_id_aux = 'required|integer|'.Rule::exists('users','id')->where('instrutor','1');
            
            
            if (!$logado->isAdmin()){

                if ($logado->isInstrutor()){
                    $isPiloto =  $logado->id == $this->piloto_id || $logado->id == $this->instrutor_id;
                }
                else{
                    $isPiloto = $logado->id == $this->piloto_id;
                }
                
            }
           
        }else{
            $tipo_instrucao_aux ='nullable|regex:/^$/i';
            $instrutor_id_aux ='nullable|regex:/^$/i';

            if (!$logado->isAdmin()){

                $isPiloto =  $logado->id == $this->piloto_id;
                
            }

        }

        if ($this->natureza=='I' && $this->piloto_id == $this->instrutor_id){
            $isPiloto = false;
        }   
        
        if (!$isPiloto){
            $is_piloto_aux ='|regex:/^$/i';
        }
        
        $resultado = [
            'piloto_id' => 'required|integer|'.Rule::exists('users','id')->where('tipo_socio','P').$is_piloto_aux,
            'data' => 'required|date|date_format:Y-m-d',
            'hora_descolagem' => 'required|date_format:H:i',
            'hora_aterragem' => 'required|date_format:H:i',
            'aeronave' => 'required|string|min:1|max:8|exists:aeronaves,matricula',
            'num_diario' =>'required|integer|min:1|max:999 999 999 99',
            'num_servico' => 'required|integer|min:1|max:999 999 999 99',
            'natureza' => 'required|in:I,E,T',
            'tipo_instrucao' => $tipo_instrucao_aux,
            'is_piloto'=>'nullable|in:0,1',
            'instrutor_id' =>  $instrutor_id_aux . $is_piloto_aux,
            'aerodromo_partida' => 'required|string|max:40|exists:aerodromos,code',
            'aerodromo_chegada' =>'required|string|max:40|exists:aerodromos,code',
            'num_aterragens' => 'required|integer|min:1|max:999 999 999 99',
            'num_descolagens' => 'required|integer|min:1|max:999 999 999 99',
            'num_pessoas' => 'required|integer|min:1|max:999 999 999 99',
            'conta_horas_inicio' => 'required|integer|between:0,99999999999',
            'conta_horas_fim' => 'required|integer|between:0,99999999999|gt:conta_horas_inicio',
            'modo_pagamento' => 'required|in:N,M,T,P',
            'num_recibo' => 'required|string|min:1|max:20',
            'tempo_voo' => 'required|integer|min:1',
            'preco_voo' => 'required|numeric|min:1',
            'observacoes' => 'string|nullable'           
        ];

        $aux = array();

        if (Auth::user()->isAdmin()) {
            $aux = ['confirmado' => 'required|in:0,1'];
            $resultado = array_merge($resultado, $aux);
        }

        return $resultado;


    }
}
