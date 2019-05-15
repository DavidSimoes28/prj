<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchUserRequest extends FormRequest
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
            'email' => 'string|email',
            'num_socio' => 'integer',
            'nome_informal' => 'string|max:40',
            'tipo_socio' => 'in:P,NP,A',
            'direcao' => ''

        ];
    }
}
