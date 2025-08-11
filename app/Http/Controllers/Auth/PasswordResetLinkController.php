<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    public function store(Request $request)
    {
        // Validación de email
        $request->validate(['email' => 'required|email']);

        // Intentar enviar el enlace de recuperación
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Retornar la respuesta según el resultado
        return $status === Password::RESET_LINK_SENT
                    ? response()->json(['status' => __($status)])
                    : response()->json(['email' => __($status)], 422);
    }
}
