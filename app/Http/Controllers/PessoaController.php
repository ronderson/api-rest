<?php

namespace App\Http\Controllers;

use App\Http\Requests\PessoaRequest;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PessoaController extends Controller
{
    public function index()
    {
        return response()->json(Pessoa::all());
    }

    public function store(PessoaRequest $request)
    {
        $pessoa = Pessoa::create($request->validated());
        return response()->json($pessoa, Response::HTTP_CREATED);
    }

    public function show(Pessoa $pessoa)
    {
        return response()->json($pessoa);
    }

    public function update(PessoaRequest $request, Pessoa $pessoa)
    {
        $pessoa->update($request->validated());
        return response()->json($pessoa);
    }

    public function destroy(Pessoa $pessoa)
    {
        $pessoa->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
