<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagBatchController extends Controller
{
    // Crear múltiples tags
    public function AddTags(Request $request, $personId)
    {
        $person = Person::find($personId);
        if ($person === null) {
            return response()->json(['message' => 'Persona no encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'tags' => 'required|array',
            'tags.*.valor' => 'required|max:255',
            'tags.*.tipo'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        foreach ($request->tags as $tagData) {
            Tag::CreateTag($person, $tagData['valor'], $tagData['tipo']);
        }

        return response()->json($person->tags);
    }

    // Actualizar múltiples tags
    public function UpdateTags(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tags' => 'required|array',
            'tags.*.id'    => 'required|exists:tags,id',
            'tags.*.valor' => 'required|max:255',
            'tags.*.tipo'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        foreach ($request->tags as $tagData) {
            $tag = Tag::find($tagData['id']);
            $tag->valor = $tagData['valor'];
            $tag->tipo  = $tagData['tipo'];
            $tag->save();
        }

        return response()->json(['message' => 'Tags actualizados correctamente']);
    }

    // Eliminar múltiples tags
    public function DeleteTags(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tags' => 'required|array',
            'tags.*' => 'required|exists:tags,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Tag::destroy($request->tags);

        return response()->json(['message' => 'Tags eliminados correctamente']);
    }
}
