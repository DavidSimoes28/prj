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
            //'matricula' => ['required', 'string', 'min:1', 'max:8', 'unique:aeronaves'], //,matricula,'.$aeronave->matricula],     //Rule::unique('aeronaves')->ignore($aeronave->matricula)],           
            'matricula' => ['required','string','min:1','max:8',Rule::unique('aeronaves')->ignore($aeronave->matricula,"matricula")],
            'marca' => 'required|string|max:40',
            'modelo' => 'required|max:40',
            'num_lugares' => 'required|integer|min:1|max:99999999999',
            'conta_horas' => 'required|integer|min:1|max:99999999999',
            'preco_hora'  => 'required|numeric|between:0,99999999999.99'
        ];
    }
}
