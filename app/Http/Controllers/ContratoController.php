<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Estudio;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ContratoController extends Controller
{
    public function save(Request $request, $ide, $idu)
    {
        $usuario = Usuario::find($idu);
        $estudio = Estudio::find($ide);

        if (is_null($usuario) || is_null($estudio)) {
            return response()->json([
                'ok' => false,
                'error' => 'El contrato debe especificar un usuario y un estudio valido'
            ]);
        }

        $reglas = [
            'total' => 'required',
            'fecha' => 'required'
        ];

        $validate = Validator::make($request->all(), $reglas);

        if ($validate->fails()) {
            return response()->json(['ok' => false, 'errors' => $validate->errors()]);
        }

        $campos = $request->all();

        $campos['id_estudio'] = $ide;
        $campos['id_usuario'] = $idu;

        $contratorealizado = Contrato::create($campos);

        return response()->json([
            'ok' => true,
            'code' => 200,
            'data' => $contratorealizado
        ], 200);
    }

    public function delete($ide, $idc)
    {

        $contrato = Contrato::find($idc);

        if (is_null($contrato)) {
            return response()->json([
                'ok' => false,
                'code' => 404,
                'error' => "El contrato no existe"
            ], 404);
        }

        if ($ide != $contrato->id_estudio) {
            return response()->json([
                'ok' => false,
                'error' => "El contrato no pertence a este estudio"
            ]);
        }

        $contrato->delete();

        return response()->json([
            'ok' => true,
            'code' => 200,
            'data' => $contrato
        ], 200);
    }

    public function getAll($ide)
    {

        $estudio = Estudio::find($ide);

        if (is_null($estudio)) {
            return response()->json([
                'ok' => false,
                'error' => 'No existe el id del estudio'
            ]);
        }

        $contratos = DB::table('contratos')
            ->where('contratos.id_estudio', $ide)
            ->get();

        return response()->json([
            'ok' => true,
            'code' => 200,
            'data' => $contratos
        ], 200);
    }
}
