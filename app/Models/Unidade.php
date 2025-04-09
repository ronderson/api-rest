<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    protected $table = 'unidade';
    protected $primaryKey = 'unid_id';
    protected $keyType = 'int';
    protected $fillable = ['unid_nome', 'unid_sigla'];


    protected static function booted()
    {
        static::deleting(function ($unidade) {
            // Guarda os endereços antes de apagar a unidade
            $enderecos = $unidade->enderecos;

            // Remove os vínculos da tabela pivot
            $unidade->enderecos()->detach();

            // Para cada endereço, verifica se ainda está vinculado a outra unidade
            foreach ($enderecos as $endereco) {
                if ($endereco->unidades()->count() === 0) {
                    $endereco->delete();
                }
            }
        });
    }

    public function lotacoes()
    {
        return $this->hasMany(Lotacao::class, 'unid_id');
    }

    public function scopeSearch($query, $request = null)
    {
        $results = $query->where(function ($queryFilter) use ($request) {
            if ($request->filter) {
                $queryFilter->whereLike('unid_nome', "%{$request->filter}%")
                    ->orWhereLike('unid_sigla', "%{$request->filter}%");
            }
            return $queryFilter;
        });

        return $results;
    }

    public function enderecos()
    {
        return $this->belongsToMany(Endereco::class, 'unidade_endereco', 'unid_id', 'end_id');
    }
}
