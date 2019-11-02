<?php namespace App\Http\Controllers;

use App\Gateway;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Response;
use DB;


class GatewaysController extends Controller {

    const MODEL = "App\Gateway";



    public function remove($id)
    {
        $m = self::MODEL;
        if(is_null($m::find($id))){
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


    public function datatables(){
        $m = self::MODEL;

        $gateways = $m::all();
//        return DataTable()->of($gateways)->toJson();
        return response()->json($gateways);
    }

    use RESTActions;

}
