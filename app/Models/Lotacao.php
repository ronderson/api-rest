<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lotacao extends Model
{
    protected $table = 'lotacao';
    protected $primaryKey = 'lot_id';
    protected $fillable = ['pes_id', 'unid_id', 'lot_data_lotacao', 'lot_data_remocao', 'lot_portaria'];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pes_id');
    }
    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unid_id');
    }
}
