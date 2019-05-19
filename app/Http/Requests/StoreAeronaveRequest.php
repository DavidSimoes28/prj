<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAeronaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'matricula' => 'required|string|max:8',
            'marca' => 'required|string|max:40',
            'modelo' => 'required|max:40',
            'num_lugares' => 'required|integer|min:1|max:99999999999',
            'conta_horas' => 'required|integer|min:1|max:99999999999',
            'preco_hora' => 'required|numeric|min:0|max:99999999999.99'
        ];
    }
}
