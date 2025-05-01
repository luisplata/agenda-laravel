<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\ProfileVisit;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonController extends Controller
{
    //
    public function CreatePerson(Request $request)
    {
        $validatedData = Validator::make($request->all(),
            [
                'nombre' => 'required|max:255',
                'about' => 'required',
                'horario' => 'required',
                'tarifa' => 'required',
                'whatsapp' => 'required',
                'telegram' => 'required',
                'mapa' => 'required',
            ]);
        if ($validatedData->fails()) {
            return response()->json($validatedData->errors(), 422);
        }
        $user = auth('api')->user();
        $person = Person::create([
            'nombre' => $request->nombre,
            'about' => $request->about,
            'horario' => $request->horario,
            'tarifa' => $request->tarifa,
            'whatsapp' => $request->whatsapp,
            'telegram' => $request->telegram,
            'mapa' => $request->mapa,
            'user_id' => $user->id
        ]);
        $person->tags()->create([
            'tipo' => 'about_me',
            'valor' => $request->about,
        ]);
        $person->tags()->create([
            'tipo' => 'nombre',
            'valor' => $request->nombre,
        ]);
        $person->tags()->create([
            'tipo' => 'whatsapp',
            'valor' => $request->whatsapp,
        ]);
        $person->tags()->create([
            'tipo' => 'telegram',
            'valor' => $request->telegram,
        ]);
        $person->load('tags');
        return response()->json($person, 201);
    }

    public function GetPeople()
    {
        $visiblePeople = Person::whereHas('user.subscription', function ($query) {
            $query->where('status', 1)->where('expires_at', '>', now());
        })->get();
        if ($visiblePeople->isEmpty()) {
            return response()->json();
        }
        $visiblePeople->load('tags');
        $visiblePeople->load('media');
        return response()->json($visiblePeople);
    }

    public function GetAllPeople()
    {
        $visiblePeople = Person::all();
        if ($visiblePeople->isEmpty()) {
            return response()->json();
        }
        $visiblePeople->load('tags');
        $visiblePeople->load('media');
        return response()->json($visiblePeople);
    }

    public function GetPerson($id)
    {
        $person = Person::find($id);
        if ($person === null) {
            return response()->json(['message' => 'Persona no encontrada'], 404);
        }

        $person->load('tags');
        $person->load('media');

        ProfileVisit::create([
            'profile_id' => $person->id,
        ]);

        return response()->json($person);
    }

    public function UpdatePerson(Request $request, $id)
    {
        $person = Person::find($id);
        if ($person === null) {
            return response()->json(['message' => 'Persona no encontrada'], 404);
        }
        $validatedData = Validator::make($request->all(),
            [
                'nombre' => 'required|max:255',
                'about' => 'required',
                'horario' => 'required',
                'tarifa' => 'required',
                'whatsapp' => 'required',
                'telegram' => 'required',
                'mapa' => 'required',
            ]);
        if ($validatedData->fails()) {
            return response()->json($validatedData->errors(), 422);
        }
        $person->nombre = $request->nombre;
        $person->about = $request->about;
        $person->horario = $request->horario;
        $person->tarifa = $request->tarifa;
        $person->whatsapp = $request->whatsapp;
        $person->telegram = $request->telegram;
        $person->mapa = $request->mapa;
        $person->update();
        return response()->json($person);
    }

    public function DeletePerson($id)
    {
        $person = Person::find($id);
        if ($person === null) {
            return response()->json(['message' => 'Persona no encontrada'], 404);
        }
        $person->delete();
        return response()->json(['message' => 'Persona eliminada']);
    }

    public function IncrementView($id)
    {
        $person = Person::find($id);
        if ($person === null) {
            return response()->json(['message' => 'Persona no encontrada'], 404);
        }

        $tag = Tag::where('person_id', $person->id)
            ->where('tipo', 'views')
            ->first();
        $view = 1;
        if ($tag) {
            $tag->valor = (int)$tag->valor + 1; // Convertir a número, incrementar y guardar
            $tag->save();
            $view = $tag->valor;
        } else {
            Tag::CreateTag($person, "1", "views");
        }
        return response()->json(["message" => "Ok", "views" => $view]);
    }
}
