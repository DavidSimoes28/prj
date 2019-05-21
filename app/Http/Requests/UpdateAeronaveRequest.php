<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAeronaveRequest extends FormRequest
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
        $aeronave = $this->route('aeronave');

        return [
            'matricula' => ['required', 'string', 'min:1', 'max:8', 'unique:aeronaves'], //,matricula,'.$aeronave->matricula],     //Rule::unique('aeronaves')->ignore($aeronave->matricula)],           
            'matricula' => 'required|string|min:1|max:8|unique:aeronaves,matricula,'.$aeronave->matricula.',' . $aeronave->getKeyName(),
            'marca' => 'required|string|min:1|max:40',
            'modelo' => 'required|min:1|max:40',
            'num_lugares' => 'required|integer|min:1|max:999 999 999 99',
            'conta_horas' => 'required|integer|min:1|max:999 999 999 99',
            'preco_hora'  => 'required|numeric|min:0|max:999 999 999 99,99'
        ];
    }
}
