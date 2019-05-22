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
        $is_piloto_aux='0,1';
        $nome_informal_aux='';
        $natureza_aux = 'I,E,T';
        $aux=User::where('id',Auth::user()->id)->first();
        if($aux->nome_informal==$this->nome_informal){
            
            $nome_informal_aux='regex:/^$/i';

            }else{

            if($this->is_piloto){
                
                if($this->natureza=='I'){
                    $nome_informal_aux='required|string|min:1|max:40|exists:users,nome_informal|';
                    
                    $nome_informal_aux.=Rule::exists('users')->where(function($query){
                        $query->where('nome_informal',$this->nome_informal);
                        $query->where('tipo_socio','P');
                        $query->where('instrutor','1');
                    });
                    

                }else{
                    $natureza_aux = 'E,T';
                    $nome_informal_aux='nullable|regex:/^$/i';

                }
            }else{
                //ele é instrutor
                if($aux->intrutor != null && $aux->intrutor){
                    $is_piloto_aux='0';
                }
                
                $natureza_aux='I';
                $nome_informal_aux='required|string|min:1|max:40|exists:users,nome_informal|';
                $nome_informal_aux.=Rule::exists('users')->where(function($query){
                    $query->where('nome_informal',$this->nome_informal);
                    $query->where('tipo_socio','P');
                });
                
            
            }
        }


        
        
        return [
            'data' => 'required|date',
            'hora_descolagem' => 'required',
            'hora_aterragem' => 'required',
            'aeronave' => 'required|string|min:1|max:8|exists:aeronaves,matricula',
            'num_diario' =>'required|integer|min:1|max:999 999 999 99',
            'num_servico' => 'required|integer|min:1|max:999 999 999 99',
            'natureza' => 'required|in:'.$natureza_aux,
            'tipo_instrucao' => 'required|in:D,S',
            'is_piloto'=>'required|in:'.$is_piloto_aux,
            'nome_informal' => $nome_informal_aux,
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
    }
}

