<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
    //
    public function uploadImage(Request $request, $personId)
    {
        // Validar que el archivo sea una imagen
        $validate = Validator::make($request->all(),            [
            'file' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', // Máximo 2 MB
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        // Guardar la imagen en el disco
        $filePath = $request->file('file')->store('images', 'public_html');

        // Guardar en la base de datos
        $media = Media::create([
            'type' => 'image',
            'file_path' => $filePath,
            'person_id' => $personId,
        ]);

        return response()->json([
            'message' => 'Imagen subida exitosamente',
            'media' => $media,
        ], 201);
    }

    public function uploadVideo(Request $request, $personId)
    {
        // Validar que el archivo sea un video
        $validate = Validator::make($request->all(),            [
            'file' => 'required|mimes:mp4,mov,avi,wmv|max:10240', // Máximo 10 MB
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        // Guardar el video en el disco
        $filePath = $request->file('file')->store('videos', 'public_html');

        // Guardar en la base de datos
        $media = Media::create([
            'type' => 'video',
            'file_path' => $filePath,
            'person_id' => $personId,
        ]);

        return response()->json([
            'message' => 'Video subido exitosamente',
            'media' => $media,
        ], 201);
    }
}
