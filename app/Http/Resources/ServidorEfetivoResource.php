<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon as Carbon;

class ServidorEfetivoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $pessoa = $this->pessoa;
        $endereco = $pessoa?->enderecos->first(); // pode vir null

        return [
            'pes_id' => $pessoa?->pes_id,
            'se_matricula' => $this->se_matricula,
            'pessoa' => $pessoa ? [
                'nome' => $pessoa->pes_nome,
                'data_nascimento' => $pessoa->pes_data_nascimento ? Carbon::parse($pessoa->pes_data_nascimento)->format('d/m/Y') : null,
                'sexo' => $pessoa->pes_sexo,
                'mae' => $pessoa->pes_mae,
                'pai' => $pessoa->pes_pai,
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
            ] : null,
            'created_at' => $this->created_at?->format('d/m/Y H:i'),
        ];
    }
}
