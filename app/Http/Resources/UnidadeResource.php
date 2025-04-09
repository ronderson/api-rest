<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnidadeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $endereco = $this->enderecos->first(); // pode vir null

        return [
            'unid_id' => $this->unid_id,
            'unid_nome' => $this->unid_nome,
            'unid_sigla' => $this->unid_sigla,
            'endereco' => $endereco ? [
                'tipo_logradouro' => $endereco->end_tipo_logradouro,
                'logradouro' => $endereco->end_logradouro,
                'numero' => $endereco->end_numero,
                'bairro' => $endereco->end_bairro,
                'cidade' => [
                    'cid_id' => $endereco->cidade->cid_id ?? null,
                    'cid_nome' => $endereco->cidade->cid_nome ?? null,
                    'cid_uf' => $endereco->cidade->cid_uf ?? null,
                ]
            ] : null,
            'created_at' => $this->created_at?->format('Y-m-d H:i'),
        ];
    }
}
