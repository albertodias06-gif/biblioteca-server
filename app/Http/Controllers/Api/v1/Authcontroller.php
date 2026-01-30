<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use app\Models\User;

class Authcontroller extends Controller
{
    // 1. Registo de usuario

    public function register(Request $request) {
     //validar dados
    $request->validate([
        'name'=>'required|string|max:255',
        'username'=>'reqired|string|max:255|unique:users,username',
        'email'=>'reqired|string|email|max:255|unique:users,email',
        'password'=>'reqired|string|min:8|confirmed',
        'type'=>'reqired|string|in:admin,user,librarian',
      ]);

     //criacao dos utilizadores
     $user = User::create([
          'name' => $request->name,
          'usaername' => $request ->username,
          'email' => $request->email,
          'type' => $request->type,


        ]);

     return respon()->json([
        'message' => 'User registered successfully',
        'user' => $user,

     ]);
    }

     // 2. login dos usuario
    public function login(request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',

        ]);

        $user = User::where('email', $request->email)->first();

       if (!$user || !Hash::check($request->password, $user->password)) {
    return response()->json([
        'message' => 'Credenciais inválidas'
    ], 401);
}
        // verificar se o usuario esta activo
        if (!$user->is_active) {
            return response()->json([
                'message' => 'Usuario inactivo. Contacte o administrador.'
            ], 403);
        }

        // criacao os token de acesso


    // 3. Logout de usuario


}
}
