<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnidadeRequest;
use App\Http\Resources\UnidadeResource;
use App\Models\Unidade;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class UnidadeController extends Controller
{

    public function __construct(protected Unidade $unidade) {}


    public function index(Request $request)
    {
        $unidades = $this->unidade->search($request)->paginate(env('PAGINATE'))->withQueryString();
        return UnidadeResource::collection($unidades);
    }

    public function store(UnidadeRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $unidade = Unidade::create($data);
            $unidade->enderecos()->create($data);
            $unidade->load('enderecos.cidade');
            DB::commit();
            return new UnidadeResource($unidade);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => "Erro ao cadastrar Unidade!",
            ], 400);
        }
    }



    public function show(Unidade $unidade)
    {
        $unidade->load('enderecos.cidade');
        return new UnidadeResource($unidade);
    }

    public function update(UnidadeRequest $request, Unidade $unidade)
    {
        $data = $request->validated();
        try {
            DB::beginTransaction();

            // Atualiza dados da unidade
            $unidade->update($data);

            // Atualiza o primeiro endereço vinculado
            $endereco = $unidade->enderecos()->first();

            if ($endereco) {
                $endereco->update($data);
            }

            $unidade->load('enderecos.cidade');
            DB::commit();

            return new UnidadeResource($unidade);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => "Erro ao alterar Unidade!",
            ], 400);
        }
    }

    public function destroy(Unidade $unidade)
    {

        $unidade->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
