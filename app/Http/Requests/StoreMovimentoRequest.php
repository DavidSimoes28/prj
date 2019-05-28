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
        $is_piloto_aux='0,1';
        $tipo_instrucao_aux = 'in:D,S';
        $instrutor_id_aux = '';
        if($this->natureza=='I' || $this->instrutor_id!=null){
            $instrutor_id_aux = ['integer',Rule::exists('users','id')->where('instrutor','1')];
        }else{
            $tipo_instrucao_aux ='nullable|regex:/^$/i';
            $instrutor_id_aux ='nullable|regex:/^$/i';
        }
        

        return [
            'piloto_id' => ['required','integer',Rule::exists('users','id')->where('tipo_socio','P')],
            'data' => 'required|date|date_format:Y-m-d',
            'hora_descolagem' => 'required|date_format:H:i',
            'hora_aterragem' => 'required|date_format:H:i',
            'aeronave' => 'required|string|min:1|max:8|exists:aeronaves,matricula',
            'num_diario' =>'required|integer|min:1|max:999 999 999 99',
            'num_servico' => 'required|integer|min:1|max:999 999 999 99',
            'natureza' => 'required|in:I,E,T',
            'tipo_instrucao' => $tipo_instrucao_aux,
            'is_piloto'=>'nullable|in:0,1',
            'instrutor_id' =>  $instrutor_id_aux,
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
    }
}
