<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMovimentoRequest extends FormRequest
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

        $resultado = array();
        $aux = array();
        $logado = Auth::user();

        $resultado = [
            'data' => 'required|date',
            
            'natureza' => 'required|in:T,E,I',
            'hora_descolagem' => 'required',
            'hora_aterragem' => 'required',
            'aeronave' => 'required|string|min:1|max:8|exists:aeronaves,matricula',
            'num_diario' =>'required|integer|min:1|max:999 999 999 99',
            'num_servico' => 'required|integer|min:1|max:999 999 999 99',
            'tipo_instrucao' => 'required|in:D,S',
            'aerodromo_partida' => 'required|string|max:40|exists:aerodromos,code',
            'aerodromo_chegada' =>'required|string|max:40|exists:aerodromos,code',
            'num_aterragens' => 'required|integer|min:1|max:999 999 999 99',
            'num_descolagens' => 'required|integer|min:1|max:999 999 999 99',
            'num_pessoas' => 'required|integer|min:1|max:999 999 999 99',
            'conta_horas_inicio' => 'required|integer|min:1|max:999 999 999 99',
            'conta_horas_fim' => 'required|integer|min:1|max:999 999 999 99',
            'modo_pagamento' => 'required|in:N,M,T,P',
            'num_recibo' => 'required|integer|min:1|max:999 999 999 99',
            'observacoes' => 'string|nullable'
        ];

        if ( $logado->isAdmin() ){
            $aux = [
                'nome_informal_piloto' => 'required|string|min:1|max:40|exists:users,nome_informal|different:nome_informal_instrutor',
                'nome_informal_instrutor' => 'nullable|string|max:40|exists:users,nome_informal|required_unless:natureza,T,E',
                'confirmado' => 'required|in:0,1'
            ];
            $resultado = array_merge($resultado, $aux);
            
            return $resultado;
        }


        $nome_informal_aux='';

        if($this->is_piloto){
            
            if($this->natureza=='I'){
                
                $nome_informal_aux.= Rule::exists('users')->where(function($query){
                    $query->where('nome_informal',$this->nome_informal);
                    $query->where('tipo_socio','P');
                    $query->where('instrutor','1');
                });

                $nome_informal_aux = User::where(function($query){
                    $query->where('nome_informal',$this->nome_informal);
                    $query->where('tipo_socio','P');
                    $query->where('instrutor','1');
                });

                dd($nome_informal_aux);
                

            }
        }else{
            //ele é instrutor
            
            //$natureza_aux='I';
            //$nome_informal_aux='required|string|min:1|max:40|exists:users,nome_informal|';
            /*$nome_informal_aux.=Rule::exists('users')->where(function($query){
                $query->where('nome_informal',$this->nome_informal);
                $query->where('tipo_socio','P');
            });*/
            
        
        }
        


        if (isset ($this->nome_informal) && $logado->nome_infomal == $this->nome_informal){
            $nome_informal_aux.='|regex:/^$/';
        }
        
        $aux = [
            'is_piloto'=>'required|in:0,1',
            'nome_informal' => 'required_if:natureza,I|max:40'. $nome_informal_aux          
        ];

        $resultado = array_merge($resultado, $aux);

        return $resultado;


    }
}

