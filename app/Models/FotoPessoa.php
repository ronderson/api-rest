<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class FotoPessoa extends Model
{

    protected $table = 'foto_pessoa';

    protected $fillable = [
        'fp_bucket',
        'fp_hash'
    ];

    // Caso o modelo tenha um relacionamento com a tabela 'pessoa'
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pes_id');
    }
}
