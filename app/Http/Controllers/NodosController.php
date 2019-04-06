<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Gateway;

class NodosController extends Controller {

    const MODEL = "App\Nodo";


    public function add(Request $request)
    {
        try {
            //controlar si el gw ya esta registrado
            $gw = Gateway::where('gw_id' , '=' ,$request->input('gw_id'))->firstOrFail();
            $m = self::MODEL;
            $this->validate($request, $m::$rules);
            return $this->respond(Response::HTTP_CREATED, $m::create($request->all()));
        }catch (\Exception $exp){
            //registrar nuevo gateway
            $m = self::MODEL;
            $this->validate($request, $m::$rules);

            $gw = new Gateway();
            $gw->gw_id = $request->input('gw_id');
            $gw->nombre = 'gw_'.$request->input('gw_id');
            $gw->lat  = 0.0;
            $gw->long = 0.0;
            $gw->freq = '433.3';
            $gw->save();

            return $this->respond(Response::HTTP_CREATED, $m::create($request->all()));
//            return $exp->getMessage();
        }


    }

    use RESTActions;

}
