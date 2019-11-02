<?php
namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Hashing\BcryptHasher;

class UsersController extends Controller {

 public function add(Request $request){
     $request['api_token'] = str_random(60);
     $request['password']  = app('hash')->make($request['password']);
     $user = User::create($request->all());

     return response()->json($user);
 }

 public function  edit( Request $request, $id) {
     $user = User::findOrFail($request->$id);
     $user->update($request->all());

     return response()->json($user);
 }



}