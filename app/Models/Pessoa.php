<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Pessoa extends Model
{
    protected $table = 'pessoa';
    protected $primaryKey = 'pes_id';
    protected $fillable = ['pes_nome', 'pes_data_nascimento', 'pes_sexo', 'pes_mae', 'pes_pai'];

    public function setPesDataNascimentoAttribute($value)
    {
        if ($value) {
            try {
                $this->attributes['pes_data_nascimento'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            } catch (\Exception $e) {
                // opcional: lançar exceção customizada ou apenas deixar como null
                $this->attributes['pes_data_nascimento'] = null;
            }
        }
    }

    public function servidorEfetivo()
    {
        return $this->hasOne(ServidorEfetivo::class, 'pes_id');
    }
    public function servidorTemporario()
    {
        return $this->hasOne(ServidorTemporario::class, 'pes_id');
    }
    public function foto()
    {
        return $this->hasOne(FotoPessoa::class, 'pes_id');
    }
    public function enderecos()
    {
        return $this->belongsToMany(
            Endereco::class,
            'pessoa_endereco',
            'pes_id',
            'end_id'
        );
    }
}
