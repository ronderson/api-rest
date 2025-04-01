<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LotacaoController extends Controller
{
    public function index()
    {
        return response()->json(Lotacao::all());
    }

    public function store(LotacaoRequest $request)
    {
        $lotacao = Lotacao::create($request->validated());
        return response()->json($lotacao, Response::HTTP_CREATED);
    }

    public function show(Lotacao $lotacao)
    {
        return response()->json($lotacao);
    }

    public function update(UpdateLotacaoRequest $request, Lotacao $lotacao)
    {
        $lotacao->update($request->validated());
        return response()->json($lotacao);
    }

    public function destroy(Lotacao $lotacao)
    {
        $lotacao->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
