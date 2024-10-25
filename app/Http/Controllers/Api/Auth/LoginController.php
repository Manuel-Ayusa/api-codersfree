<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;//para verificar la contraseña del request(no cifrada) con la contraseña de la bd(cifrada)
use App\Http\Resources\UserResource;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->firstOrFail(); //busca el email en la base de datos y si no existe devuelve false

        if (Hash::check($request->password, $user->password)) {
            return UserResource::make($user); //retorna el usuario en el formato que veniamos haciendo 
        } else {
            return response()->json(['message' => 'These credentials do not match our records', 404]); 
        }
    }
}
