<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServidorEfetivoRequest;
use App\Http\Resources\EnderecoFuncionalResource;
use App\Http\Resources\ServidorEfetivoResource;
use App\Http\Resources\ServidorLotadoResource;
use App\Models\Endereco;
use App\Models\Lotacao;
use App\Models\Pessoa;
use App\Models\ServidorEfetivo;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ServidorEfetivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $servidorEfetivo = ServidorEfetivo::with('pessoa.enderecos')
            ->search($request)
            ->paginate(env('PAGINATE'))
            ->withQueryString();
        return ServidorEfetivoResource::collection($servidorEfetivo);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServidorEfetivoRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $pessoa = Pessoa::create($data);  // Criar pessoa
            $endereco = Endereco::create($data); // Criar endereço
            $pessoa->enderecos()->attach($endereco->end_id);  // Relacionar pessoa e endereço
            $servidor = ServidorEfetivo::create([
                'pes_id' => $pessoa->pes_id,
                'se_matricula' => $data['se_matricula'],
            ]); // Criar servidor efetivo
            DB::commit();
            $servidor->load('pessoa.enderecos.cidade');

            return new ServidorEfetivoResource($servidor);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => "Erro ao cadastrar Servidor Efetivo!",
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ServidorEfetivo $servidor)
    {
        return new ServidorEfetivoResource($servidor->load('pessoa.enderecos.cidade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServidorEfetivoRequest $request, ServidorEfetivo $servidor)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

            $pessoa = $servidor->pessoa;  // Atualiza a pessoa
            $pessoa->update($data);

            $endereco = $pessoa->enderecos->first(); // Atualiza o endereço (relacionado à pessoa)
            if ($endereco)
                $endereco->update($data);

            $servidor->update([
                'se_matricula' => $data['se_matricula'],
            ]); // Atualiza o servidor efetivo

            DB::commit();

            $servidor->load('pessoa.enderecos.cidade');

            return new ServidorEfetivoResource($servidor);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => "Erro ao Alterar Servidor Efetivo!",
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServidorEfetivo $servidor)
    {
        $servidor->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function servidoresLotados($unid_id)
    {
        $lotacoes = Lotacao::with(['pessoa.servidorEfetivo', 'pessoa', 'unidade'])
            ->where('unid_id', $unid_id)

            ->paginate(env("PAGINATE"));

        return ServidorLotadoResource::collection($lotacoes);
    }

    public function buscarEnderecoFuncional(Request $request)
    {
        $nome = $request->input('nome');

        if (!$nome) {
            return response()->json(['message' => 'Parâmetro nome é obrigatório'], 400);
        }

        $servidores = ServidorEfetivo::with(['pessoa', 'lotacoes.unidade.enderecos.cidade'])
            ->whereHas('pessoa', function ($query) use ($nome) {
                $query->where('pes_nome', 'ILIKE', "%{$nome}%");
            })
            ->paginate(env("PAGINATE"))
            ->withQueryString();

        return EnderecoFuncionalResource::collection($servidores);
    }
}
