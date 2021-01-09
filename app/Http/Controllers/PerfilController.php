<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PerfilController extends Controller
{
    public function upload(Request $request, $idu)
    {

        $usuario = Usuario::find($idu);

        if (is_null($usuario)) {
            return response()->json([
                'ok' => false,
                'code' => 404,
                'error' => 'El id del usuario no se encontro'
            ], 404);
        }

        $reglas = [
            'file0' => 'required|image|mimes:jpg,jpeg,png',
            'file1' => 'required|image|mimes:jpg,jpeg,png',
            'file2' => 'required|image|mimes:jpg,jpeg,png'
        ];

        $validate = Validator::make($request->all(), $reglas);

        if ($validate->fails()) {
            return response()->json(['ok' => false, 'errors' => $validate->errors()]);
        }

        $image0 = $request->file('file0');
        $image1 = $request->file('file1');
        $image2 = $request->file('file2');

        $imagen_name0 = time() . $image0->getClientOriginalName();
        $imagen_name1 = time() . $image1->getClientOriginalName();
        $imagen_name2 = time() . $image2->getClientOriginalName();

        $image0->storeAs('public/perfil', $imagen_name0);
        $image1->storeAs('public/perfil', $imagen_name1);
        $image2->storeAs('public/perfil', $imagen_name2);

        Perfil::create([
            'filename' => $imagen_name0,
            'id_usuario' => $idu
        ]);

        Perfil::create([
            'filename' => $imagen_name1,
            'id_usuario' => $idu
        ]);

        Perfil::create([
            'filename' => $imagen_name2,
            'id_usuario' => $idu
        ]);

        return response()->json([
            'ok' => true,
            'code' => 200,
            'msg' => 'Las imagenes se subieron correctamente'
        ], 200);
    }


    public function getPerfil($idusuario)
    {
        $usuario = Usuario::find($idusuario);

        if (is_null($usuario)) {
            return response()->json([
                'ok' => false,
                'code' => 404,
                'error' => "No se encontro un usuario con es id"
            ]);
        }

        $photos = DB::table('perfils')->where('id_usuario', $idusuario)->get();

        return response()->json([
            'ok' => true,
            'code' => 200,
            'data' => $photos
        ]);
    }

    public function getImage($filename)
    {
        if (Storage::disk('public')->exists('perfil/' . $filename)) {

            $file = Storage::disk('public')->get('perfil/' . $filename);
            return new Response($file, 200);
        }

        return response()->json([
            'ok' => false,
            'code' => 404,
            'error' => 'Filename no econtrado'
        ], 404);
    }
}
