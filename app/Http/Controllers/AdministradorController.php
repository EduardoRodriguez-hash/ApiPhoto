<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdministradorController extends Controller
{
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

        $admin = DB::table('administradors')
            ->where('email', $request->email)
            ->first();

        if (is_null($admin)) {
            return response()->json([
                'ok' => false,
                'code' => 404,
                'error' => 'El email es incorrecto'
            ], 404);
        }

        if (!(Hash::check($request->pass, $admin->pass))) {
            return response()->json([
                'ok' => false,
                'code' => 404,
                'error' => "password incorrecto"
            ], 404);
        }

        return response()->json([
            'ok' => true,
            'code' => 200,
            'data' => $admin
        ], 200);
    }
}
