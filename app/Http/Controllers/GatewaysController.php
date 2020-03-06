<?php

namespace App\Http\Controllers;

use App\Gateway;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Response;
use DB;


class GatewaysController extends Controller
{

    const MODEL = "App\Gateway";



    public function remove($id)
    {
        $m = self::MODEL;
        if (is_null($m::find($id))) {
            return $this->respond(Response::HTTP_NOT_FOUND);
        }

        try {
            DB::beginTransaction(); //Start db transaction for rollback query when error
            $m::find(3)->delete();
            $m::withTrashed()->restore();
            DB::commit(); //Commit the query
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback the query
            //Optional, if we need to continue execution only rollback transaction and save message on variable
            throw new \Askedio\SoftCascade\Exceptions\SoftCascadeLogicException($e->getMessage());
        }

        $m::destroy($id);
        return $this->respond(Response::HTTP_NO_CONTENT);
    }


    public function datatables()
    {
        $m = self::MODEL;

        $gateways = $m::all();
        //        return DataTable()->of($gateways)->toJson();
        return response()->json($gateways);
    }


    public function all()
    {
        $m = self::MODEL;
        DB::statement("SET sql_mode = '' "); // si da error en group by
        $gateways = DB::table('gateways')->get();
        $gatewayss = collect($gateways)->map(function ($gateway) {
            $gateway->formEditar = "<p>
                                <h5><b>" . $gateway->nombre . "</b>
                                </h5>
                            </p>
                            <p>Frecuencia:" . $gateway->freq . "</p>
                            <input type='hidden' id='nodo_id' value='" . $gateway->id . "' />
                            <input type='hidden' id='gw_id' value='" . $gateway->gw_id . "' />
                            <input type='hidden' id='tipo_nodo' value='sensor' />
                            <p><i class='glyphicon glyphicon-eye-open'></i>
                            <a href='./gateway/" . $gateway->id . "'> Ver</a></p>";
            return $gateway;
        });
        return response()->json($gatewayss, 200);
        // return $this->respond(Response::HTTP_OK, $nodos);
    }

    public function allEditable()
    {
        $m = self::MODEL;
        DB::statement("SET sql_mode = '' "); // si da error en group by
        $gateways = DB::table('gateways')->get();
        $gatewayss = collect($gateways)->map(function ($gateway) {
            $gateway->formEditar = "<p>
                                <h5><b>" . $gateway->nombre . "</b>
                                </h5>
                            </p>
                            <p>Frecuencia:" . $gateway->freq . "</p>
                            <input type='hidden' id='nodo_id' value='" . $gateway->id . "' />
                            <input type='hidden' id='gw_id' value='" . $gateway->gw_id . "' />
                            <input type='hidden' id='tipo_nodo' value='sensor' />
                            <p><i class='glyphicon glyphicon-eye-open'></i>
                            <a href='./gateway/" . $gateway->id . "'> Ver</a></p>
                            <p>
                                <button type='button' class='btn btn-info btn-labeled btn-lg legitRipple'  data-toggle='modal' data-target='#modal_form_edit'>
                                    <b><i class='glyphicon glyphicon-pencil'></i></b> Editar
                                </button>
                            </p>
                            <p>
                                <button type='button' class='btn btn-danger btn-labeled btn-lg legitRipple'  onclick='clearMarkers();'>
                                    <b><i class='glyphicon glyphicon-remove'></i></b> Eliminar
                                </button>
                            </p>";
            return $gateway;
        });
        return response()->json($gatewayss, 200);
    }


    public function get($id)
    {
        $m = self::MODEL;

        $gateway = Gateway::find($id);
        
        if (empty($gateway)) {
            return response()->json(['error' => "Gateway no encontrado"], 422);
        }
        $nodos = $gateway->nodos;
        
        return response()->json(['gateway' => $gateway]);
    }


    use RESTActions;
}
