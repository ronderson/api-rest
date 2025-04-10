<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadFotoPessoaRequest;
use App\Models\FotoPessoa;
use App\Models\Pessoa;
use Illuminate\Support\Facades\Storage;

class FotoPessoaController extends Controller
{

    public function upload(UploadFotoPessoaRequest $request)
    {
        $urls = [];

        foreach ($request->file('fotos') as $foto) {
            $hash = uniqid() . '.' . $foto->getClientOriginalExtension();

            Storage::disk('s3')->put($hash, file_get_contents($foto));

            FotoPessoa::create([
                'pes_id' => $request->pes_id,
                'fp_data' => now(),
                'fp_bucket'  => env('AWS_BUCKET'),
                'fp_hash' => $hash,
            ]);

            $url = Storage::disk('s3')->temporaryUrl(
                $hash,
                now()->addMinutes(5)
            );

            $urls[] = [
                'fp_hash' => $hash,
                'url_temporaria' => $url,
            ];
        }

        return response()->json(['fotos' => $urls], 201);
    }
}
