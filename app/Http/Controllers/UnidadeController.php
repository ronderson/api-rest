<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnidadeRequest;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UnidadeController extends Controller
{
    public function index()
    {
        return response()->json(Unidade::all());
    }

    public function store(UnidadeRequest $request)
    {
        $unidade = Unidade::create($request->validated());
        return response()->json($unidade, Response::HTTP_CREATED);
    }

    public function show(Unidade $unidade)
    {
        return response()->json($unidade);
    }

    public function update(UnidadeRequest $request, Unidade $unidade)
    {
        $unidade->update($request->validated());
        return response()->json($unidade);
    }

    public function destroy(Unidade $unidade)
    {
        $unidade->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
