<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class FotoPessoa extends Model
{    protected $table = 'foto_pessoa';
    protected $primaryKey = 'fp_id';

    protected $fillable = [
        'pes_id',
        'fp_data',
        'fp_bucket',
        'fp_hash'
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pes_id');
    }
}
