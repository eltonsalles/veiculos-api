<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VeiculoRequest extends FormRequest
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
            'veiculo' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'ano' => 'required|integer',
            'descricao' => 'required|string',
            'vendido' => 'required|boolean',
        ];
    }
}
