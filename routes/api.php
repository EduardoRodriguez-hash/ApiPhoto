<?php

use App\Http\Controllers\AdministradorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudioController;
use App\Http\Controllers\FotografoController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UsuarioController;
use App\Models\Administrador;

//Administrador
Route::post('/administrador/login', [AdministradorController::class, 'login']);


// Estudio
Route::post('/estudio/save', [EstudioController::class, 'save']);
Route::post('/estudio/update/{id}', [EstudioController::class, 'update']);
Route::delete('/estudio/delete/{id}', [EstudioController::class, 'delete']);
Route::get('/estudio/all', [EstudioController::class, 'getAll']);
Route::get('/estudio/last/{num}', [EstudioController::class, 'getLast']);
Route::get('/estudio/{id}', [EstudioController::class, 'getOne']);
Route::post('/estudio/login', [EstudioController::class, 'login']);
Route::post('/estudio/upload/{ide}', [EstudioController::class, 'upload']);
Route::get('/estudio/getImage/{filename}', [EstudioController::class, 'getImage'])->name('getImagePhoto');
Route::get('/estudio/search/{search}', [EstudioController::class, 'search']);


//Fotografo
Route::post('/fotografo/save/{ide}', [FotografoController::class, 'save']);
Route::delete('/fotografo/delete/{ide}/{idf}', [FotografoController::class, 'delete']);
Route::get('/fotografo/all/{ide}', [FotografoController::class, 'getAll']);

//Contrato
Route::post('/contrato/save/{ide}/{idu}', [ContratoController::class, 'save']);
Route::delete('/contrato/delete/{ide}/{idc}', [ContratoController::class, 'delete']);
Route::get('/contrato/all/{ide}', [ContratoController::class, 'getAll']);

//Evento
Route::post('/evento/save/{ide}/{idc}', [EventoController::class, 'save']);
Route::post('/evento/update/{ide}/{idc}', [EventoController::class, 'update']);
Route::delete('/evento/delete/{idevent}/{idest}', [EventoController::class, 'delete']);
Route::get('/evento/all/{ide}', [EventoController::class, 'getAll']);

//Usuario
Route::post('/usuario/save', [UsuarioController::class, 'save']);
Route::post('/usuario/update/{idu}', [UsuarioController::class, 'update']);
Route::post('/usuario/login', [UsuarioController::class, 'login']);

//Perfil
Route::post('/perfil/upload/{idu}', [PerfilController::class, 'upload']);
Route::get('/perfil/get/{idusuario}', [PerfilController::class, 'getPerfil']);
Route::get('/getImage/perfil/{filename}', [PerfilController::class, 'getImage'])->name('getImagePerfil');

//Foto
Route::get('/foto/getAll/{idestudio}/{idevento}', [FotoController::class, 'getAll']);
Route::get('/getImage/foto/{personId}', [FotoController::class, 'getPhoto']);
