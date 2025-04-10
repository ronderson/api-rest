<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FotoPessoaController;
use App\Http\Controllers\LotacaoController;
use App\Http\Controllers\PessoaController;
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

/**
 * Auth
 */
Route::post('/auth', [AuthController::class, 'auth']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');


Route::middleware(['auth:sanctum', 'token.expiration'])->group(function () {

    Route::get('/unidades/{unid_id}/servidores-lotados', [ServidorEfetivoController::class, 'servidoresLotados']);
    Route::get('/servidores/endereco-funcional', [ServidorEfetivoController::class, 'buscarEnderecoFuncional']);
    Route::post('/fotos/upload', [FotoPessoaController::class, 'upload']);
    
    // CRUD de Unidade
    Route::apiResource('/unidades', UnidadeController::class);
    // CRUD de Servidor Efetivo
    Route::apiResource('/servidores-efetivos', ServidorEfetivoController::class)
        ->parameters(['servidores-efetivos' => 'servidor']);
    // CRUD de Servidor Temporário
    Route::apiResource('/servidores-temporarios', ServidorTemporarioController::class)
        ->parameters(['servidores-temporarios' => 'servidor']);
    // CRUD de Lotação
    Route::apiResource('/lotacoes', LotacaoController::class)
        ->parameters(['lotacoes' => 'lotacao']);

    Route::get('/pessoas/{id}/foto', [PessoaController::class, 'fotoTemporaria']);
});

//Route::post('upload-fotografias', [FotoPessoaController::class, 'upload']);


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
