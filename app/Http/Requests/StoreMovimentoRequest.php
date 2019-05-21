<?php

namespace App\Http\Requests;

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
        return [
            'data' => 'required|date',
            'hora_descolagem' => 'required',
            'hora_aterragem' => 'required',
            'aeronave' => 'required|string|min:1|max:8',
            'num_diario' =>'required|integer|min:1|max:999 999 999 99',
            'num_servico' => 'required|integer|min:1|max:999 999 999 99',
            'natureza' => 'required|in:T,I,E',
            'tipo_instrucao' => 'required|in:D,S',
            'name' => 'string|max:40|nullable',
            'aerodromo_partida' => 'required|string|max:40',
            'aerodromo_chegada' =>'required|string|max:40',
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
