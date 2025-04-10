<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LotacaoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'lot_id' => $this->lot_id,
            'lot_data_lotacao' => $this->lot_data_lotacao ? Carbon::parse($this->lot_data_lotacao)->format('d/m/Y') : null, //Carbon::parse($pessoa->pes_data_nascimento)->format('d/m/Y') : null
            'lot_data_remocao' => $this->lot_data_remocao ? Carbon::parse($this->lot_data_remocao)->format('d/m/Y') : null,
            'lot_portaria' => $this->lot_portaria,

            'pessoa' => $this->whenLoaded('pessoa', fn() => [
                'pes_id' => $this->pessoa->pes_id,
                'pes_nome' => $this->pessoa->pes_nome,
            ]),

            'unidade' => $this->whenLoaded('unidade', fn() => [
                'unid_id' => $this->unidade->unid_id,
                'unid_nome' => $this->unidade->unid_nome,
                'unid_sigla' => $this->unidade->unid_sigla,
            ]),

            'created_at' => $this->created_at?->format('Y-m-d H:i'),
        ];
    }
}
