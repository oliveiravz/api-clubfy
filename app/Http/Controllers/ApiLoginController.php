<?php

namespace App\Http\Controllers;

use App\Models\Login,
    App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiLoginController extends Controller
{

    public function validate(Request $request)
    {
        $data = $request->all();

        $request->validate([
            'email' => 'required|email',
            'senha' => 'required|min:6',
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        dd($usuario);

        if (!$usuario || !Hash::check($request->senha, $usuario->senha)) {
            return response()->json(['error' => 'Credenciais inválidas'], 401);
        }

        session(['usuario' => $usuario]);

        return response()->json(['message' => 'Login bem-sucedido', 'usuario' => $usuario]);

    }
}
