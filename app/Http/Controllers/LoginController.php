<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function login(Request $req)
    {
        // validacion del request	
        $validate = $this->validate($req, [
            'email' => 'email|required',
            'password' => 'required'
        ]);

        // consulta del usuario
        $user = User::where('email', $req->input('email'))->first();

        if (empty($user)) {
            return response()->json(['status' => 'fail', 'message' => 'Los datos son incorrectos'], 401);
        }
        // return response()->json(['password' => $user->password, 'pass hash' => Hash::make($req->input('password'))]);
        // verificaion de contraseña
        if (Hash::check($req->input('password'), $user->password)) {

            // creamos un string random para el token
            $api_token = str_random(50);

            // le seteamos el api_token al usuario
            $user->api_token = $api_token;

            // guardamos
            $user->save();

            // retornamos el api_token, para futuras peticiones
            return response()->json(['status' => 'success', 'api_token' => $api_token, 'user' => $user->name]);
        } else {

            return response()->json(['status' => 'fail', 'message' => 'Los datos son incorrectos'], 401);
        }
    }


    public function logout(Request $req)
    {
        User::where('api_token', $req->input('api_token'))->update(['api_token' => null]);
        return response()->json(['status' => 'success']);
    }
}
