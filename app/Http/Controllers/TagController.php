<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function AddTag(Request $request, $id)
    {
        $person = Person::find($id);
        if ($person === null) {
            return response()->json(['message' => 'Persona no encontrada'], 404);
        }
        $tag = Validator::make($request->all(),
            [
                'valor' => 'required|max:255',
                'tipo' => 'required',
            ]);
        if ($tag->fails()) {
            return response()->json($tag->errors(), 422);
        }
        Tag::CreateTag($person, $request->valor, $request->tipo);
        return response()->json($person->tags);
    }

    public function UpdateTag(Request $request, $id)
    {
        $tag = Tag::find($id);
        if ($tag === null) {
            return response()->json(['message' => 'Tag no encontrada'], 404);
        }
        $tag->valor = $request->valor;
        $tag->tipo = $request->tipo;
        $tag->save();
        return response()->json($tag);
    }

    public function DeleteTag($id)
    {
        $tag = Tag::find($id);
        if ($tag === null) {
            return response()->json(['message' => 'Tag no encontrada'], 404);
        }
        $tag->delete();
        return response()->json(['message' => 'Tag eliminada']);
    }
}
