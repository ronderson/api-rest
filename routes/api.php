<?php

use App\Http\Controllers\FotoPessoaController;
use App\Http\Controllers\LotacaoController;
use App\Http\Controllers\ServidorEfetivoController;
use App\Http\Controllers\ServidorTemporarioController;
use App\Http\Controllers\UnidadeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'success' => true
    ]);
});

Route::apiResource('unidades', UnidadeController::class);
Route::resource('servidores-efetivos', ServidorEfetivoController::class);
Route::post('upload-fotografias', [FotoPessoaController::class, 'upload']);


// Route::middleware('auth:sanctum')->group(function () {
//     // CRUD de Servidor Efetivo
//     Route::resource('servidores-efetivos', ServidorEfetivoController::class);
//     // CRUD de Servidor Temporário
//     Route::resource('servidores-temporarios', ServidorTemporarioController::class);
//     // CRUD de Unidade
//     // Route::resource('unidades', UnidadeController::class);
//     // CRUD de Lotação
//     Route::resource('lotacoes', LotacaoController::class);

//     // Endpoint para consultar servidores efetivos lotados em determinada unidade
//     Route::get('servidores/unidade/{unid_id}', [ServidorEfetivoController::class, 'getServidoresPorUnidade']);

//     // Endpoint para consultar endereço funcional do servidor efetivo
//     Route::get('servidores/endereco/{nome}', [ServidorEfetivoController::class, 'getEnderecoFuncionario']);

//     // Endpoint para upload de imagens
//     Route::post('upload-fotografias', [ServidorEfetivoController::class, 'uploadFotografia']);
// });
