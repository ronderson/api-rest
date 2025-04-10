<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LotacaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pes_id' => 'required|exists:pessoa,pes_id',
            'unid_id' => 'required|exists:unidade,unid_id',
            'lot_data_lotacao' => 'required|date_format:d/m/Y',
            'lot_data_remocao' => 'nullable|date_format:d/m/Y|after_or_equal:lot_data_lotacao',
            'lot_portaria' => 'required|string|max:100',
        ];
    }
}
