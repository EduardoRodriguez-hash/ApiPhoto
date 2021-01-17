<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    public function save(Request $request)
    {
        $reglas = [
            'id' => 'required|min:7|unique:usuarios',
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email|unique:usuarios',
            'pass' => 'required|min:8',
            'telefono' => 'required|min:8',
        ];

        $validate = Validator::make($request->all(), $reglas);

        if ($validate->fails()) {
            return response()->json(['ok' => false, 'error' => $validate->errors()]);
        }

        $campos = $request->all();

        $campos['pass'] = Hash::make($request->pass);

        $usuariocreado = Usuario::create($campos);

        return response()->json([
            'ok' => true,
            'code' => 200,
            'data' => $usuariocreado
        ], 200);
    }

    public function update(Request $request, $idu)
    {
        $usuario = Usuario::find($idu);

        if (is_null($usuario)) {

            return response()->json([
                'ok' => false,
                'code' => 404,
                'error' => 'El usuario con ese id no se encontro'
            ], 404);
        }

        $reglas = [
            'nombre' => 'min:2',
            'apellido' => 'min:3',
            'pass' => 'min:8',
            'telefono' => 'min:8',
        ];

        $validate = Validator::make($request->all(), $reglas);

        if ($validate->fails()) {
            return response()->json(['ok' => false, 'errors' => $validate->errors()]);
        }

        if ($request->has('nombre')) {
            $usuario->nombre = $request->nombre;
        }
        if ($request->has('apellido')) {
            $usuario->apellido = $request->apellido;
        }
        if ($request->has('pass')) {
            $usuario->pass = Hash::make($request->pass);
        }
        if ($request->has('telefono')) {
            $usuario->telefono = $request->telefono;
        }

        $usuario->save();

        return response()->json([
            'ok' => true,
            'code' => 200,
            'data' => $usuario
        ], 200);
    }

    public function login(Request $request)
    {
        $reglas = [
            'email' => 'required|email',
            'pass' => 'required|min:8'
        ];

        $validate = Validator::make($request->all(), $reglas);

        if ($validate->fails()) {
            return response()->json(['ok' => false, 'errors' => $validate->errors()]);
        }

        $posibleUser = DB::table('usuarios')
            ->where('email', $request->email)
            ->first();

        if (is_null($posibleUser)) {
            return response()->json([
                'ok' => false,
                'code' => 404,
                'error' => 'El email es incorrecto'
            ], 404);
        }

        if (!(Hash::check($request->pass, $posibleUser->pass))) {
            return response()->json([
                'ok' => false,
                'code' => 404,
                'error' => "password incorrecto"
            ], 404);
        }

        return response()->json([
            'ok' => true,
            'code' => 200,
            'data' => $posibleUser
        ], 200);
    }
}
