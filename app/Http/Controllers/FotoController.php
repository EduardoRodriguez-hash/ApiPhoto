<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FotoController extends Controller
{
    public function getAll($idestudio, $idevento)
    {
        $contrato = DB::table('fotos')
            ->where('fotos.id_evento', $idevento)
            ->join('eventos', 'eventos.id', 'fotos.id_evento')
            ->join('contratos', 'contratos.id', 'eventos.id_contrato')
            ->select('contratos.*')
            ->first();

        if (is_null($contrato)) {
            return response()->json([
                'ok' => false,
                'code' => 404,
                'error' => 'No hay imagenes con esos datos'
            ]);
        }

        if ($contrato->id_estudio != $idestudio) {
            return response()->json([
                'ok' => false,
                'error' => 'Estos datos no pertenercen al estudio'
            ]);
        }

        $FotosAll = DB::table('fotos')->where('id_evento', $idevento)->get();

        return response()->json([
            'ok' => true,
            'code' => 200,
            'data' => $FotosAll
        ], 200);
    }

    public function getPhoto($personId)
    {
        $foto = DB::table('fotos')->where('personId', $personId)->first();

        if (is_null($foto)) {
            return response()->json([
                'ok' => false,
                'code' => 404,
                'error' => 'No se encotro la imagen'
            ]);
        }

        if (Storage::disk('public')->exists('photo/' . $foto->filename)) {

            $file = Storage::disk('public')->get('photo/' . $foto->filename);

            return new Response($file, 200);
        }

        return response()->json([
            'ok' => false,
            'code' => 404,
            'error' => 'Filename no econtrado'
        ], 404);
    }
}
