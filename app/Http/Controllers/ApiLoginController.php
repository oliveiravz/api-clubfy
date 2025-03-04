<?php

namespace App\Http\Controllers;

use App\Models\Login,
    App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth,
    Illuminate\Support\Facades\Hash;

class ApiLoginController extends Controller
{
    public function validate(Request $request)
    {
        try {
            
            $data = $request->all();

            $erros = [];
            
            var_dump($data);exit;
            if(empty($data["email"])) {
                throw new \Exception("E-mail é um campo obrigatório");
            }
    
            if(empty($data["password"])) {
                throw new \Exception("Senha é um campo obrigatório");
            }

            $user = Login::join('usuario','usuario.id','=','login.usuario_id')
                    ->where('login.email', trim($data['email']))
                    ->select('login.*', 'usuario.*')
                    ->first();
                    
            if (!$user || ($user->senha !== md5($data['password']))) {
                throw new \Exception('Usuário não encontrado!');
            }
    
            session(['usuario_logado' => $user]);
    
            return response()->json(['message' => 'Login bem-sucedido', 'usuario_logado' => $user]);

        } catch (\Exception $e) {
            
            return response()->json([
                'success'     => false,
                'message'     => 'Erro ao processar a solicitação. Por favor, tente novamente mais tarde.',
                'error'       => mb_convert_encoding($e->getMessage(), 'UTF-8', 'auto'), 
            ], 500);
            
            
        }

    }
}
