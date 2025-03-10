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

            if(empty($data["email"])) {
                throw new \Exception("E-mail é um campo obrigatório");
            }
    
            if(empty($data["password"])) {
                throw new \Exception("Senha é um campo obrigatório");
            }

            $user = Login::join('usuario','usuario.id','=','login.usuario_id')
                    ->where('login.email', trim($data['email']))
                    ->select('login.email', 'login.senha', 'usuario.nome', 'usuario.nivel_acesso')
                    ->first()->toArray();

            if (!$user || ($user["senha"] !== md5($data['password']))) {
                throw new \Exception('Usuário não encontrado!');
            }else{

                unset($user["senha"]);
                
                $content = [
                    'success' => true,
                    'status_code' => 200,
                    'user' => $user
                ];
            }
    
            return response()->json($content);

        } catch (\Exception $e) {

            $content = [
                'success' => false,
                'message' => $e->getMessage(),
                'status_code' => 500
            ];
            
            return response()->json($content);
        }
    }
}
