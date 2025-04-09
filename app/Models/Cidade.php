<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cidade extends Model
{
    protected $table = 'cidade';
    protected $primaryKey = 'cid_id';
    public $timestamps = false;

    protected $fillable = [
        'cid_nome',
        'cid_uf',
    ];

    /**
     * Relacionamento com Endereços.
     */
    public function enderecos(): HasMany
    {
        return $this->hasMany(Endereco::class, 'cid_id', 'cid_id');
    }
}
