<?php

namespace Database\Seeders;

use App\Models\Cidade;
use App\Models\Unidade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CidadeSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Cidade::where('cid_nome', 'Cuiaba')->first()) {
            Cidade::create([
                'cid_nome' => 'Cuiaba',
                'cid_uf' => 'MT',

            ]);
        }
        if (!Cidade::where('cid_nome', 'Rondonopolis')->first()) {
            Cidade::create([
                'cid_nome' => 'Rondonopolis',
                'cid_uf' => 'MT',

            ]);
        }
        if (!Cidade::where('cid_nome', 'Varzea Grande')->first()) {
            Cidade::create([
                'cid_nome' => 'Varzea Grande',
                'cid_uf' => 'MT',

            ]);
        }

    }
}
