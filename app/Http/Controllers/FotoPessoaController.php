<?php

namespace App\Http\Controllers;

use App\Models\FotoPessoa;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class FotoPessoaController extends Controller
{


    public function upload(Request $request)
    {
        try {
            // Processando o upload do arquivo
            if ($request->hasFile('foto')) {

                $file = $request->file('foto');

                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

                $path = Storage::disk('s3')->put("fotos/{$fileName}", file_get_contents($file), 'public');

                // // Se falhar no upload
                // if (!$path) {
                //     return response()->json(['message' => 'Falha ao enviar a foto.'], 500);
                // }

                $foto = FotoPessoa::create([
                   // 'pes_id' => $request->pes_id,
                    'pes_id' => 1,
                    'fp_bucket' => env('AWS_BUCKET'),
                    'fp_hash' => $fileName,
                ]);

                // Retorna a URL temporária da imagem
                return response()->json([
                    'message' => 'Foto enviada com sucesso!',
                    'foto' => $foto,
                    'url' => Storage::disk('s3')->url("fotos/{$fileName}")
                ], 201);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao processar a imagem.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
