<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServidorTemporarioRequest;
use App\Http\Resources\ServidorTemporarioResource;
use App\Models\Endereco;
use App\Models\Pessoa;
use App\Models\ServidorEfetivo;
use App\Models\ServidorTemporario;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ServidorTemporarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $servidorTemporario = ServidorTemporario::with('pessoa.enderecos')
            ->search($request)
            ->paginate(env('PAGINATE'))
            ->withQueryString();
        return ServidorTemporarioResource::collection($servidorTemporario);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServidorTemporarioRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $pessoa = Pessoa::create($data);  // Criar pessoa
            $endereco = Endereco::create($data); // Criar endereço
            $pessoa->enderecos()->attach($endereco->end_id);  // Relacionar pessoa e endereço
            $servidor = ServidorTemporario::create([
                'pes_id' => $pessoa->pes_id,
                'st_data_admissao' => $data['st_data_admissao'],
                'st_data_demissao' => $data['st_data_demissao']
            ]); // Criar servidor efetivo
            DB::commit();
            $servidor->load('pessoa.enderecos.cidade');

            return new ServidorTemporarioResource($servidor);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => "Erro ao cadastrar Servidor Temporario!",
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ServidorTemporario $servidor)
    {
        return new ServidorTemporarioResource($servidor->load('pessoa.enderecos.cidade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServidorTemporarioRequest $request, ServidorTemporario $servidor)
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
                'st_data_admissao' => $data['st_data_admissao'],
                'st_data_demissao' => $data['st_data_demissao']
            ]); // Atualiza o servidor Temporario

            DB::commit();

            $servidor->load('pessoa.enderecos.cidade');

            return new ServidorTemporarioResource($servidor);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => "Erro ao Alterar Servidor Temporario!",
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServidorTemporario $servidor)
    {
        $servidor->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
