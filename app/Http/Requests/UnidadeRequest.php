<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UnidadeRequest extends FormRequest
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
        $unidadeId = $this->unidade->unid_id ?? null;
        return [
            'unid_nome' => [
                'bail',
                'required',
                'string',
                'min:3,max:200',
                Rule::unique('unidade', 'unid_nome')->ignore($unidadeId, 'unid_id')
            ],
            'unid_sigla' => [
                'bail',
                'required',
                'string',
                'max:20',
                Rule::unique('unidade', 'unid_sigla')->ignore($unidadeId, 'unid_id')
            ],
            'end_tipo_logradouro' => [
                'required',
                'string',
                'max:50'
            ],
            'end_logradouro' => [
                'required',
                'string',
                'max:200'
            ],
            'end_numero' => [
                'required',
                'string',
                'max:20'
            ],
            'end_bairro' => [
                'required',
                'string',
                'max:100'
            ],
            'cid_id' => [
                'required',
                'integer',
                'exists:cidade,cid_id'
            ],
        ];
    }

    public function attributes()
    {
        return [
            'unid_nome' => 'Nome da unidade',
            'unid_sigla' => 'Sigla da unidade',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
