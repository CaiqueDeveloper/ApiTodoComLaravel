<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    
    public function create(Request $request)
    {
        // array

        $array = ['error' => ''];

        //criando a regra de validação

        $role = [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4'
        ];

        //validando dados enviado pelo usuario

        $validator = Validator::make($request->all(), $role);

        //verificando se ouve algum tipo de erro n validação

        if($validator->fails())
        {
            $array['error'] = $validator->getMessageBag();
            return $array;
        }

        //pegando os dados enviado pelo usario pós validação

        $email = $request->input('email');
        $password = $request->input('password');

        //criando uma instancia de um novo ususario

        $createNewUser = new User();
        $createNewUser->email = $email;
        $createNewUser->password = password_hash($password, PASSWORD_DEFAULT);
        $createNewUser->token = '';
        $createNewUser->save();

        if($createNewUser){
            $array['success'] = 'Usuario Cadastrado com Sucesso !';
            return $array;
        }

    }

    // LOGIN USING WITH SANCTUM
    // public function login(Request $request)
    // {
    //     $array = ['error' => ''];

    //     $creds = $request->only('email', 'password');

    //     if(!Auth::attempt($creds)){
    //         $array['error'] = 'E-mail e/ou Senha incorreto !';
    //         return $array;
    //     }

    //     $user = User::where('email', $creds['email'])->first();
    //     $item = time().rand(0,99999);
    //     $token = $user->createToken($item)->plainTextToken;

    //     $array['token'] = $token;

    //     return $array;
    // }

    public function login(Request $request)
    {
        $array = ['error' => ''];

        $creds = $request->only('email', 'password');

        
        $token = Auth::attempt($creds);

        if(!$token){
            $array['error'] = 'E-mail e/ou Senha incorreto !';
            return $array;
        }

        $array['token'] = $token;

        return $array;
    }
    // LOGOUT SANCTUM
    // public function logout(Request $request)
    // {
    //     $array = ['error' => ''];

    //     $user = $request->user();
    //     $user->tokens()->delete();

    //     if($user){
    //         $array['success'] = "Usuario Deslogado !";
    //         return $array;
    //     }

    //    return $array;
    // }

    public function logout(Request $request)
    {
        $array = ['error' => ''];

       

        if(Auth::logout()){
            $array['success'] = "Usuario Deslogado !";
            return $array;
        }

       return $array;
    }
}
