<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServidorEfetivoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Pessoa
            'pes_nome' => 'required|string|max:200',
            'pes_data_nascimento' => 'required|date_format:d/m/Y',
            'pes_sexo' => 'required|string|max:9',
            'pes_mae' => 'nullable|string|max:200',
            'pes_pai' => 'nullable|string|max:200',
            // Servidor Efetivo
            'se_matricula' => 'required|string|max:20',
            // Endereço
            'end_tipo_logradouro' => 'required|string|max:50',
            'end_logradouro' => 'required|string|max:200',
            'end_numero' => 'required|integer',
            'end_bairro' => 'required|string|max:100',
            'cid_id' => 'required|exists:cidade,cid_id',
        ];
    }
}
