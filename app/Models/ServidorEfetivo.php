<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServidorEfetivo extends Model
{
    protected $table = 'servidor_efetivo';
    protected $fillable = ['pes_id', 'se_matricula'];
    
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pes_id');
    }
}
