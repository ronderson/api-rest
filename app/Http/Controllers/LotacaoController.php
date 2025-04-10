<?php

namespace App\Http\Controllers;

use App\Models\Lotacao;
use App\Http\Requests\LotacaoRequest;
use App\Http\Resources\LotacaoResource;
use Illuminate\Http\Request;

class LotacaoController extends Controller
{
    public function index(Request $request)
    {
        $lotacoes = Lotacao::with(['pessoa', 'unidade'])
            ->search($request)
            ->paginate(env('PAGINATE'));

        return LotacaoResource::collection($lotacoes);
    }

    public function store(LotacaoRequest $request)
    {
        $data = $request->validated();
        $lotacao = Lotacao::create($data);
        $lotacao->load(['pessoa', 'unidade']);

        return new LotacaoResource($lotacao);
    }

    public function show(Lotacao $lotacao)
    {
        $lotacao->load(['pessoa', 'unidade']);
        return new LotacaoResource($lotacao);
    }

    public function update(LotacaoRequest $request, Lotacao $lotacao)
    {
        $data = $request->validated();
        $lotacao->update($data);
        $lotacao->load(['pessoa', 'unidade']);
        return new LotacaoResource($lotacao);
    }

    public function destroy(Lotacao $lotacao)
    {
        $lotacao->delete();
        return response()->json(null, 204);
    }
}
