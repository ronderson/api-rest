<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ServidorTemporario extends Model
{
    protected $table = 'servidor_temporario';
    protected $fillable = ['pes_id', 'st_data_admissao', 'st_data_demissao'];

    protected static function booted()
    {
        static::deleting(function (ServidorTemporario $servidor) {
            DB::transaction(function () use ($servidor) {
                $pessoa = $servidor->pessoa;

                $pessoa->enderecos()->detach(); // Desvincula endereços

                foreach ($pessoa->enderecos as $endereco) { // Deleta os endereços
                    $endereco->delete();
                }

                $pessoa->delete(); // Deleta a pessoa
            });
        });
    }


    public function setStDataAdmissaoAttribute($value)
    {
        if ($value) {
            try {
                $this->attributes['st_data_admissao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            } catch (\Exception $e) {
                // opcional: lançar exceção customizada ou apenas deixar como null
                $this->attributes['st_data_admissao'] = null;
            }
        }
    }

    public function setStDataDemissaoAttribute($value)
    {
        if ($value) {
            try {
                $this->attributes['st_data_demissao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            } catch (\Exception $e) {
                // opcional: lançar exceção customizada ou apenas deixar como null
                $this->attributes['st_data_demissao'] = null;
            }
        }
    }



    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pes_id');
    }

    public function scopeSearch($query, $request = null)
    {
        return $query->where(function ($queryFilter) use ($request) {
            if ($request->filter) {
                $queryFilter->orWhereHas('pessoa', function ($subQuery) use ($request) {
                    $subQuery->whereLike('pes_nome', "%{$request->filter}%");
                });
            }
        });
    }
}
