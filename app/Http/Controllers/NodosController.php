<?php

namespace App\Http\Controllers;

use App\Nodo;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Gateway;
use App\Measure;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NodosController extends Controller
{

    const MODEL = "App\Nodo";


    public function add(Request $request)
    {
        try {
            //controlar si el gw ya esta registrado
            $gw = Gateway::where('gw_id', '=', $request->input('gw_id'))->firstOrFail();
            if ($gw) {
                //si existe el nodo gateway, se controla si existe el nodo sensor
                $m = self::MODEL;
                $this->validate($request, $m::$rules);
                //controlar si el nodo ya esta registrado
                $nodo = Nodo::where('src', '=', $request->input("src"))->first();
                if ($nodo) {
                    //se almacenan los datos de las mediciones
                    $measure =  new Measure();
                    $measure->src   = $request->input("src");
                    $measure->dst   = $request->input("dst");
                    $measure->ptype = $request->input("ptype");
                    $measure->seq   = $request->input("seq");
                    $measure->len   = $request->input("len");
                    $measure->snr   = $request->input("snr");
                    $measure->rssi  = $request->input("rssi");
                    $measure->bw    = $request->input("bw");
                    $measure->cr    = $request->input("cr");
                    $measure->sf    = $request->input("sf");
                    $measure->tdata = $request->input("tdata");
                    $measure->tc    = $request->input("tc");
                    $measure->pa    = $request->input("pa");
                    $measure->co    = $request->input("co");
                    $measure->hu    = $request->input("hu");
                    $measure->hi    = $request->input("hi");
                    $measure->save();
                    $nodo->measures()->save($measure);
                    return $this->respond(Response::HTTP_CREATED, $nodo->measures->last());
                } else {
                    //si no existe el nodo sensor, se lo registra, luego se registran las mediciones
                    $m::create($request->all());
                    //se almacenan los datos de las mediciones
                    $measure =  new Measure();
                    $measure->src   = $request->input("src");
                    $measure->dst   = $request->input("dst");
                    $measure->ptype = $request->input("ptype");
                    $measure->seq   = $request->input("seq");
                    $measure->len   = $request->input("len");
                    $measure->snr   = $request->input("snr");
                    $measure->rssi  = $request->input("rssi");
                    $measure->bw    = $request->input("bw");
                    $measure->cr    = $request->input("cr");
                    $measure->sf    = $request->input("sf");
                    $measure->tdata = $request->input("tdata");
                    $measure->tc    = $request->input("tc");
                    $measure->pa    = $request->input("pa");
                    $measure->co    = $request->input("co");
                    $measure->hu    = $request->input("hu");
                    $measure->hi    = $request->input("hi");
                    $measure->save();
                    $m->measures()->save($measure);

                    return $this->respond(Response::HTTP_CREATED, $m->measures->last());
                }
            }
            // si no existe el nodo gateway se lanza una exepcion y se lo registra


        } catch (\Exception $exp) {

            //registrar nuevo gateway
            $m = self::MODEL;
            $this->validate($request, $m::$rules);

            $gw = new Gateway();
            $gw->gw_id = $request->input('gw_id');
            $gw->nombre = 'gw_' . $request->input('gw_id');
            $gw->lat  = 0.0;
            $gw->long = 0.0;
            $gw->freq = '433.3';
            $gw->save();

            $m = self::MODEL;
            $this->validate($request, $m::$rules);
            //controlar si el nodo ya esta registrado
            $this->existNodo($request);

            //  return $this->respond(Response::HTTP_CREATED, $m::create($request->all()));
            //            return $exp->getMessage();
        }
    }

    public function existNodo(Request $request)
    {
        $nodo = Nodo::where('src', '=', $request->input("src"))->first();
        $nodo = Nodo::where('src', '=', $request->input("src"))->first();
        if ($nodo) {
            //se almacenan los datos de las mediciones
            $measure =  new Measure();
            $measure->src   = $request->input("src");
            $measure->dst   = $request->input("dst");
            $measure->ptype = $request->input("ptype");
            $measure->seq   = $request->input("seq");
            $measure->len   = $request->input("len");
            $measure->snr   = $request->input("snr");
            $measure->rssi  = $request->input("rssi");
            $measure->bw    = $request->input("bw");
            $measure->cr    = $request->input("cr");
            $measure->sf    = $request->input("sf");
            $measure->tdata = $request->input("tdata");
            $measure->tc    = $request->input("tc");
            $measure->pa    = $request->input("pa");
            $measure->co    = $request->input("co");
            $measure->hu    = $request->input("hu");
            $measure->hi    = $request->input("hi");
            $measure->save();
            $nodo->measures()->save($measure);
            return $this->respond(Response::HTTP_CREATED, $nodo->measures->last());
        } else {
            //si no existe el nodo sensor, se lo registra, luego se registran las mediciones
            $m = self::MODEL;
            $m::create($request->all());
            //se almacenan los datos de las mediciones
            $measure =  new Measure();
            $measure->src   = $request->input("src");
            $measure->dst   = $request->input("dst");
            $measure->ptype = $request->input("ptype");
            $measure->seq   = $request->input("seq");
            $measure->len   = $request->input("len");
            $measure->snr   = $request->input("snr");
            $measure->rssi  = $request->input("rssi");
            $measure->bw    = $request->input("bw");
            $measure->cr    = $request->input("cr");
            $measure->sf    = $request->input("sf");
            $measure->tdata = $request->input("tdata");
            $measure->tc    = $request->input("tc");
            $measure->pa    = $request->input("pa");
            $measure->co    = $request->input("co");
            $measure->hu    = $request->input("hu");
            $measure->hi    = $request->input("hi");
            $measure->save();
            $m->measures()->save($measure);

            return $this->respond(Response::HTTP_CREATED, $m->measures->last());
        }
    }

    public function measures($src)
    {
        $m = self::MODEL;
        $model = $m::where("src", "=", $src)->get();
        $measures = Measure::Where('src', '=', $src)->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('i');
        });
        if (is_null($model)) {
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        return $this->respond(Response::HTTP_OK, $measures);
    }


    public function countTotal()
    {
        $gateways = Gateway::count();
        $nodos =  Nodo::groupBy('src')->getQuery()->getCountForPagination();
        $registros = Measure::count();
        $total = array();
        $total['gateways'] = $gateways;
        $total['nodes'] = $nodos;
        $total['registers'] = $registros;

        return response()->json($total, 200);
    }

    public function all()
    {
        $m = self::MODEL;
        DB::statement("SET sql_mode = '' "); // si da error en group by
        $nodos = DB::table('nodos')->groupBy('src')->get();
        return response()->json($nodos, 200);
        return $this->respond(Response::HTTP_OK, $nodos);
    }

    public function lastMeasure(Request $request)
    {
        $idNodo = $request->input('id');
        $nodo = Nodo::find($idNodo);
        $lastMeasure = Measure::where('src', $nodo->src)->latest('id')->first();
        return response()->json($lastMeasure, 200);
    }

    public function coMeasure24($idNodo)
    {
        $nodo = Nodo::findOrFail($idNodo);
        $measure = Measure::select('co', 'created_at')->whereDate('created_at', DB::raw('CURDATE()'))->where('src', $nodo->src)->orderBy('created_at', 'DESC')->get();
        return response()->json($measure, 200);
    }

    public function promedio8hs($idNodo)
    {
        $nodo = Nodo::findOrFail($idNodo);
        $promedio =  Measure::where('created_at', '>=', Carbon::now()->subHour(8))->where('src', $nodo->src)->avg('co');
        return $promedio;
    }


    public function semanal($idNodo)
    {
        $nodo = Nodo::findOrFail($idNodo);
        $measure = Measure::select('co', 'created_at', 'tc')->take(5040)->where('src', $nodo->src)->orderBy('created_at', 'DESC')->get();
        return response()->json($measure, 200);
    }

    public function historial($idNodo)
    {
        $nodo = Nodo::findOrFail($idNodo);
        $measure = Measure::select('co', 'created_at', 'tc')->where('src', $nodo->src)->orderBy('created_at', 'DESC')->get();
        return $measure;
        return response()->json($measure, 200);
    }


    public function datatables()
    {
        $m = self::MODEL;

        $nodos = $m::all();
        //        return DataTable()->of($gateways)->toJson();
        return response()->json($nodos);
    }



    use RESTActions;
}
