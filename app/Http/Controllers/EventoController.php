<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Estudio;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EventoController extends Controller
{
    public function save(Request $request, $ide, $idc)
    {
        $contrato = Contrato::find($idc);

        $estudio = Estudio::find($ide);

        if (is_null($contrato) || is_null($estudio)) {
            return response()->json([
                'ok' => false,
                'error' => 'Uno de los id del no existe'
            ], 404);
        }

        $reglas = [
            'nombre' => 'required|min:3',
            'direccion' => 'required|min:4',
            'fecha' => 'required',
            'hora' => 'required',
        ];

        $validate = Validator::make($request->all(), $reglas);

        if ($validate->fails()) {
            return response()->json(['ok' => false, 'errors' => $validate->errors()]);
        }

        if ($ide != $contrato->id_estudio) {
            return response()->json([
                'ok' => false,
                'error' => 'El contrato no pertenece a ese estudio'
            ]);
        }

        $campos = $request->all();

        $campos['id_contrato'] = $idc;

        $eventoCreado = Evento::create($campos);

        return response()->json([
            'ok' => true,
            'code' => 200,
            'data' => $eventoCreado
        ], 200);
    }

    public function update(Request $request, $ide, $idc)
    {
        $contrato = Contrato::find($idc);

        $estudio = Estudio::find($ide);

        if (is_null($contrato) || is_null($estudio)) {
            return response()->json([
                'ok' => false,
                'error' => 'Uno de los id del no existe'
            ], 404);
        }

        $reglas = [
            'nombre' => 'required|min:3',
            'direccion' => 'required|min:4',
            'fecha' => 'required',
            'hora' => 'required',
        ];

        $validate = Validator::make($request->all(), $reglas);

        if ($validate->fails()) {
            return response()->json(['ok' => false, 'errors' => $validate->errors()]);
        }

        if ($ide != $contrato->id_estudio) {
            return response()->json([
                'ok' => false,
                'error' => 'El contrato no pertenece a ese estudio'
            ]);
        }

        $campos = $request->all();

        $eventoUpdated = DB::table('eventos')
            ->where('id_contrato', $idc)
            ->update($campos);

        return response()->json([
            'ok' => true,
            'code' => 200,
            'data' => $eventoUpdated
        ], 200);
    }

    public function delete($idevent, $idest)
    {
        $estudio = Estudio::find($idest);
        $evento = Evento::find($idevent);

        if (is_null($estudio) || is_null($evento)) {
            return response()->json([
                'ok' => false,
                'error' => 'El id no existe'
            ], 404);
        }

        $result = DB::table('eventos')
            ->where('eventos.id', $idevent)
            ->join('contratos', 'contratos.id', 'eventos.id_contrato')
            ->select('contratos.*')
            ->first();

        if ($result->id_estudio != $idest) {

            return response()->json([
                'ok' => false,
                'error' => 'Solo el estudio que creo el evento puedo eliminarlo'
            ]);
        }

        $evento->delete();

        return response()->json([
            'ok' => true,
            'code' => 200,
            'data' => $evento
        ], 200);
    }

    public function getAll($ide)
    {

        $estudio = Estudio::find($ide);

        if (is_null($estudio)) {
            return response()->json([
                'ok' => false,
                'error' => 'El id del Estudio no existe'
            ], 404);
        }

        $events = DB::table('estudios')
            ->where('estudios.id', $ide)
            ->join('contratos', 'contratos.id_estudio', 'estudios.id')
            ->join('eventos', 'eventos.id_contrato', 'contratos.id')
            ->select('eventos.*')
            ->get();

        return response()->json([
            'ok' => true,
            'code' => 200,
            'data' => $events
        ], 200);
    }
}
