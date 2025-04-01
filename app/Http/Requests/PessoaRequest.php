<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PessoaRequest extends FormRequest
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
            'pes_nome' => 'required|string|max:200',
            'pes_data_nascimento' => 'nullable|date',
            'pes_sexo' => 'nullable|string|max:9',
            'pes_mae' => 'nullable|string|max:200',
            'pes_pai' => 'nullable|string|max:200',
        ];
    }
}
