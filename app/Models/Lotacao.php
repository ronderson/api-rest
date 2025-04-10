<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Lotacao extends Model
{
    protected $table = 'lotacao';
    protected $primaryKey = 'lot_id';
    protected $fillable = ['pes_id', 'unid_id', 'lot_data_lotacao', 'lot_data_remocao', 'lot_portaria'];


    public function scopeSearch($query, $request = null)
    {
        $query->when($request?->filter, function ($q) use ($request) {
            $q->whereHas('pessoa', function ($subQuery) use ($request) {
                $subQuery->whereLike('pes_nome', "%{$request->filter}%");
            })->orWhereHas('unidade', function ($subQuery) use ($request) {
                $subQuery->whereLike('unid_nome', "%{$request->filter}%");
            })->orWhereLike('lot_portaria', "%{$request->filter}%");
        });

        return $query;
    }

    public function setLotDataLotacaoAttribute($value)
    {
        if ($value) {
            try {
                $this->attributes['lot_data_lotacao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            } catch (\Exception $e) {
                // opcional: lançar exceção customizada ou apenas deixar como null
                $this->attributes['lot_data_lotacao'] = null;
            }
        }
    }

    public function setLotDataRemocaoAttribute($value)
    {
        if ($value) {
            try {
                $this->attributes['lot_data_remocao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            } catch (\Exception $e) {
                // opcional: lançar exceção customizada ou apenas deixar como null
                $this->attributes['lot_data_remocao'] = null;
            }
        }
    }
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pes_id');
    }
    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unid_id');
    }
}
