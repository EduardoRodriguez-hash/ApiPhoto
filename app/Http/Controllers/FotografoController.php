<?php

namespace App\Http\Controllers;

use App\Models\Estudio;
use App\Models\Fotografo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FotografoController extends Controller
{
    public function save(Request $request, $ide)
    {
        $estudio = Estudio::find($ide);

        if (is_null($estudio)) {
            return response()->json([
                'ok' => false,
                'error' => 'El estudio no se encontro'
            ], 404);
        }

        $reglas = [
            'id' => 'required|min:8|unique:fotografos',
            'nombre' => 'required',
            'apellido' => 'required',
            'telefono' => 'required|min:8',
        ];

        $validate = Validator::make($request->all(), $reglas);

        if ($validate->fails()) {
            return response()->json(['ok' => false, 'errors' => $validate->errors()]);
        }

        $campos = $request->all();

        $campos['id_estudio'] = $ide;

        $fotografocreado = Fotografo::create($campos);

        return response()->json([
            'ok' => true,
            'code' => 200,
            'data' => $fotografocreado
        ], 200);
    }

    public function delete($ide, $idf)
    {
        $fotografo = Fotografo::find($idf);

        if (is_null($fotografo)) {
            return response()->json([
                'ok' => false,
                'error' => 'El id no se pudo encontrar'
            ], 404);
        }

        if ($ide != $fotografo->id_estudio) {
            return response()->json([
                'ok' => false,
                'error' => 'El fotografo no pertenece a ese estudio'
            ]);
        }

        $fotografo->delete();

        return response()->json([
            'ok' => true,
            'data' => $fotografo
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

        $fotografos = DB::table('fotografos')
            ->where('fotografos.id_estudio', $ide)
            ->get();

        return response()->json([
            'ok' => true,
            'code' => 200,
            'data' => $fotografos
        ], 200);
    }
}
