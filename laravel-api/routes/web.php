<?php
use App\Http\Controllers\EstrategiaWmsController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rota POST de Estrategia
Route::post('/estrategiaWMS', [EstrategiaWmsController::class, 'storeEstrategia']);
// Rota GET para retornar prioridades
Route::get('/estrategiaWMS/{cdEstrategia}/{dsHora}/{dsMinuto}/prioridade', [EstrategiaWmsController::class, 'getEstrategia']);