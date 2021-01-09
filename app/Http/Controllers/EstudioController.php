<?php

namespace App\Http\Controllers;

use App\Models\Estudio;
use App\Models\Foto;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EstudioController extends Controller
{
    public function save(Request $request)
    {
        $reglas = [
            'nombre' => 'required|min:4',
            'descripcion' => 'required|min:10',
            'email' => 'required|email|unique:estudios',
            'pass' => 'required|min:8',
            'telefono' => 'required|min:8',
        ];

        $validate = Validator::make($request->all(), $reglas);

        if ($validate->fails()) {
            return response()->json(['ok' => false, 'errors' => $validate->errors()]);
        }

        $campos = $request->all();

        $campos['pass'] = Hash::make($request->pass);

        $estudio = Estudio::create($campos);

        return response()->json([
            'ok' => true,
            'code' => 200,
            'data' => $estudio
        ], 200);
    }


    public function update(Request $request, $id)
    {
        $estudio = Estudio::find($id);

        if (is_null($estudio)) {
            return response()->json(['ok' => false, 'error' => 'No existe un estudio con es id']);
        }

        $reglas = [
            'nombre' => 'min:3',
            'email' => 'email|unique:estudios,email,' . $estudio->id,
            'pass' => 'min:8',
            'descripcion' => 'min:10'
        ];

        $validate = Validator::make($request->all(), $reglas);

        if ($validate->fails()) {
            return response()->json(['ok' => false, 'errors' => $validate->errors()]);
        }

        if ($request->has('nombre')) {
            $estudio->nombre = $request->nombre;
        }

        if ($request->has('email')) {
            $estudio->email = $request->email;
        }

        if ($request->has('pass')) {
            $estudio->pass = Hash::make($request->pass);
        }

        if ($request->has('descripcion')) {
            $estudio->descripcion = $request->descripcion;
        }

        if (!$estudio->isDirty()) {
            return response()->json([
                'ok' => false,
                'code' => 422,
                'error' => 'Los datos son los mismos'
            ], 422);
        }

        $estudio->save();

        return response()->json([
            'ok' => true,
            'code' => 200,
            'data' => $estudio
        ], 200);
    }

    public function delete($id)
    {
        $estudio = Estudio::find($id);

        if (is_null($estudio)) {
            return response()->json(['ok' => false, 'error' => 'No existe un estudio con es id']);
        }

        $estudio->delete();

        return response()->json([
            'ok' => true,
            'code' => 200,
            'data' => $estudio
        ], 200);
    }

    public function getAll()
    {

        $estudios = Estudio::all();

        return response()->json([
            'ok' => true,
            'code' => 200,
            'data' => $estudios
        ], 200);
    }

    public function getOne($id)
    {
        $estudio = Estudio::find($id);

        if (is_null($estudio)) {
            return response()->json(['ok' => false, 'error' => 'No existe un estudio con es id']);
        }

        return response()->json([
            'ok' => true,
            'data' => $estudio
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

        $estudio = DB::table('estudios')
            ->where('email', $request->email)
            ->first();

        if (is_null($estudio)) {
            return response()->json([
                'ok' => false,
                'code' => 404,
                'error' => 'El email es incorrecto'
            ], 404);
        }

        if (!(Hash::check($request->pass, $estudio->pass))) {
            return response()->json([
                'ok' => false,
                'code' => 404,
                'error' => "password incorrecto"
            ], 404);
        }

        return response()->json([
            'ok' => true,
            'code' => 200,
            'data' => $estudio
        ], 200);
    }

    public function upload(Request $request, $ide)
    {
        $imagen = $request->file('file');

        $reglas = [
            'file' => 'required|image|mimes:jpg,jpeg,png',
            'precio' => 'required',
            'personId' => 'required'
        ];

        $validate = Validator::make($request->all(), $reglas);

        if (!$imagen || $validate->fails()) {
            return response()->json(['ok' => false, 'errors' => $validate->errors()]);
        }

        $imagen_name = time() . $imagen->getClientOriginalName();

        //Save imagen

        $imagen->storeAs('public/photo', $imagen_name);

        //No se esta validanao si el evento existe

        $fotosubida = Foto::create([
            'filename' => $imagen_name,
            'precio' => $request->precio,
            'id_evento' => $ide,
            'personId' => $request->personId
        ]);

        return response()->json([
            'ok' => true,
            'code' => 200,
            'msg' => 'La imagen se subio correctamente',
            'data' => $fotosubida
        ], 200);
    }

    public function getImage($filename)
    {

        if (Storage::disk('public')->exists('photo/' . $filename)) {

            $file = Storage::disk('public')->get('photo/' . $filename);
            return new Response($file, 200);
        }

        return response()->json([
            'ok' => false,
            'code' => 404,
            'error' => 'Filename no econtrado'
        ], 404);
    }

    public function search($search)
    {
        $results = DB::table('estudios')
            ->where('nombre', 'like', '%' . $search . '%')
            ->get();


        if (count($results) == 0) {
            return response()->json([
                'ok' => false,
                'code' => 404,
                'msg' => 'No se ecnontraron coincidencias :('
            ], 404);
        }

        return response()->json([
            'ok' => true,
            'code' => 200,
            'data' => $results
        ], 200);
    }

    public function getLast($num)
    {

        $estudios = DB::table('estudios')
            ->orderBy('id', 'desc')
            ->limit($num)
            ->get();

        return response()->json([
            'ok' => true,
            'code' => 200,
            'data' => $estudios
        ], 200);
    }
}
