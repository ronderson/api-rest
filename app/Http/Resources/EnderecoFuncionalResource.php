<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnderecoFuncionalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $pessoa = $this->pessoa;
        $lotacao = $this->lotacoes->first();
        $unidade = $lotacao?->unidade;
        $endereco = $unidade?->enderecos->first();

        return [
            'nome' => $pessoa->pes_nome,
            'unidade' => $unidade?->unid_nome,
            'endereco' => $endereco ? [
                'tipo_logradouro' => $endereco->end_tipo_logradouro,
                'logradouro' => $endereco->end_logradouro,
                'numero' => $endereco->end_numero,
                'bairro' => $endereco->end_bairro,
                'cidade' => [
                    'cid_nome' => $endereco->cidade->cid_nome ?? null,
                    'cid_uf' => $endereco->cidade->cid_uf ?? null,
                ],
            ] : null,
        ];
    }
}
