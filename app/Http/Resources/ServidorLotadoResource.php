<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ServidorLotadoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $pessoa = $this->pessoa;

        return [
            'nome' => $pessoa->pes_nome,
            'idade' => Carbon::parse($pessoa->pes_data_nascimento)->age,
            'unidade' => $this->unidade->unid_nome ?? null,
            'fotografias' => $pessoa->fotos->map(function ($foto) {
                return Storage::disk('s3')->temporaryUrl(
                    $foto->fp_hash,
                    now()->addMinutes(5)
                );
            })
        ];
    }
}
