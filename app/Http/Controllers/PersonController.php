<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    //
    public function CreatePerson(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'about' => 'required',
            'horario' => 'required',
            'tarifa' => 'required',
            'whatsapp' => 'required',
            'telegram' => 'required',
            'mapa' => 'required',
        ]);
        if($validatedData->fails()){
            return response()->json($validatedData->errors(), 422);
        }
        $person = Person::create([
            'nombre' => $request->nombre,
            'about' => $request->about,
            'horario' => $request->horario,
            'tarifa' => $request->tarifa,
            'whatsapp' => $request->whatsapp,
            'telegram' => $request->telegram,
            'mapa' => $request->mapa,
        ]);
        return response()->json($person, 201);
    }

    public function GetPeople()
    {
        $people = Person::all();
        if($people->isEmpty()){
            return response()->json(['message' => 'No hay personas registradas'], 404);
        }
        return response()->json($people);
    }

    public function GetPerson($id)
    {
        $person = Person::find($id);
        if($person === null){
            return response()->json(['message' => 'Persona no encontrada'], 404);
        }
        return response()->json($person);
    }

    public function UpdatePerson(Request $request, $id)
    {
        $person = Person::find($id);
        if($person === null){
            return response()->json(['message' => 'Persona no encontrada'], 404);
        }
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'about' => 'required',
            'horario' => 'required',
            'tarifa' => 'required',
            'whatsapp' => 'required',
            'telegram' => 'required',
            'mapa' => 'required',
        ]);
        if($validatedData->fails()){
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
        if($person === null){
            return response()->json(['message' => 'Persona no encontrada'], 404);
        }
        $person->delete();
        return response()->json(['message' => 'Persona eliminada']);
    }
}
