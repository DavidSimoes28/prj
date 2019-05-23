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
            $natureza_aux = '';
            $nome_informal_piloto_aux = '';
            $nome_informal_instrutor_aux = '';

            if ($this->natureza != 'I'){
                $natureza_aux = '|regex:/^$/';
            }

            $piloto = User::all()
            ->where('nome_informal',$this->nome_informal_piloto)
            ->where ('tipo_socio','P')->count(); 
                
            if (!$piloto){
                $nome_informal_piloto_aux='|regex:/^$/';
            }

            $instrutor = User::all()
            ->where('nome_informal',$this->nome_informal_piloto)
            ->where ('tipo_socio','P')
            ->where('instrutor','1')
            ->count();
                
            if (!$instrutor){
                $nome_informal_instrutor_aux='|regex:/^$/';
            }

            $aux = [
                'nome_informal_piloto' => 'required|string|min:1|max:40|exists:users,nome_informal|different:nome_informal_instrutor' . $nome_informal_piloto_aux,
                'nome_informal_instrutor' => 'nullable|string|max:40|exists:users,nome_informal|required_unless:natureza,T,E'.$natureza_aux . $nome_informal_instrutor_aux,
                'confirmado' => 'required|in:0,1'
            ];
            $resultado = array_merge($resultado, $aux);
            
            return $resultado;
        }

        
      


        $nome_informal_aux='';
        $is_piloto_aux='';

        if($this->is_piloto){
            
            if($this->natureza=='I'){

                $nome_informal_aux = User::all()
                ->where('nome_informal',$this->nome_informal)
                ->where ('tipo_socio','P')
                ->where('instrutor','1')->count(); 
                
                if (!$nome_informal_aux){
                    $nome_informal_aux='|regex:/^$/';
                }

                if ($logado->nome_informal == $this->nome_informal){
                    $nome_informal_aux='|regex:/^$/';
                }
                

            }
        }
        else {

            if ($this->natureza != 'I'){
                $is_piloto_aux = '|regex:/^$/';
            }

        }
        


        
        
        $aux = [
            'is_piloto'=>'required|in:0,1'.$is_piloto_aux,
            'nome_informal' => 'required_if:natureza,I|max:40'. $nome_informal_aux          
        ];

        $resultado = array_merge($resultado, $aux);

        return $resultado;


    }
}

