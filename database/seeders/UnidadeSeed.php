<?php

namespace Database\Seeders;

use App\Models\Endereco;
use App\Models\Unidade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnidadeSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unidade = Unidade::firstOrCreate([
            'unid_nome' => 'Unidade Central',
            'unid_sigla' => 'UC',
        ]);

        $endereco = Endereco::firstOrCreate([
            'end_tipo_logradouro' => 'Rua',
            'end_logradouro' => 'Rua do Sol',
            'end_numero' => '101',
            'end_bairro' => 'Centro',
            'cid_id' => 1,
        ]);

        $unidade->enderecos()->syncWithoutDetaching([$endereco->end_id]);
    }
}
