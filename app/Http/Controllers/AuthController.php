<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function Register(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json($validatedData->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json($user, 201);
    }

    public function Login(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json($validatedData->errors(), 422);
        }

        $credentials = $request->only(['email', 'password']);

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'Credenciales incorrectas'], 401);
            }
            $user = User::where('email', $request->email)->first();
            $user->token = $token;
            $user->save();
            return response()->json(['token' => $token, "profile" => $user->role]);
        } catch (JWTException $e) {
            return response()->json(['message' => 'No se pudo crear el token'], 500);
        }
    }

    public function GetUser(Request $request)
    {
        $user = Auth::user();

        $userData = $user->only(['id', 'name', 'email', 'role']);

        $person = Person::where('user_id', $user->id)->latest();

        if ($person != null) {

            $person->load('tags');

            $userData['Persona'] = $person;
        }

        return response()->json($userData);
    }

    public function Logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Sesión cerrada']);
        } catch (JWTException $e) {
            return response()->json(['message' => 'No se pudo cerrar la sesión'], 500);
        }
    }
}
