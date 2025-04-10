<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServidorEfetivo extends Model
{
    protected $table = 'servidor_efetivo';
    protected $fillable = ['pes_id', 'se_matricula'];


    protected static function booted()
    {
        static::deleting(function (ServidorEfetivo $servidor) {
            DB::transaction(function () use ($servidor) {
                $pessoa = $servidor->pessoa;

                $pessoa->enderecos()->detach(); // Desvincula endereços

                foreach ($pessoa->enderecos as $endereco) { // Deleta os endereços (caso queira)
                    $endereco->delete();
                }

                $pessoa->delete(); // Deleta a pessoa
            });
        });
    }

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pes_id');
    }

    public function lotacoes()
    {
        return $this->hasMany(Lotacao::class, 'pes_id', 'pes_id');
    }

    public function scopeSearch($query, $request = null)
    {
        return $query->where(function ($queryFilter) use ($request) {
            if ($request->filter) {
                $queryFilter->whereLike('se_matricula',  "%{$request->filter}%")
                    ->orWhereHas('pessoa', function ($subQuery) use ($request) {
                        $subQuery->whereLike('pes_nome', "%{$request->filter}%");
                    });
            }
        });
    }
}
