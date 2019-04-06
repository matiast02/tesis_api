<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Nodo extends Model {

    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [ "lat", "long", "freq", "dst", "ptype", "src", "seq", "len", "snr", "rssi", "bw", "cr", "sf", "tdata", "tc", "pa", "co", "hu", "nombre", "gw_id"];

    protected $dates = [];

    public static $rules = [
        "gw_id" => "required",
        "freq" => "numeric|required",
        "dst" => "numeric|required",
        "ptype" => "numeric|required",
        "src" => "numeric|required",
        "seq" => "numeric|required",
        "len" => "numeric|required",
        "snr" => "numeric|required",
        "rssi" => "numeric|required",
        "bw" => "numeric|required",
        "cr" => "numeric|required",
        "sf" => "numeric|required",
        "tdata" => "string|required",
        "tc" => "numeric|required",
        "pa" => "numeric",
        "co" => "numeric",
        "hu" => "numeric",
        "nombre" => "string|min:3|max:300",
    ];

    public $timestamps = false;

    public function owner()
    {
        return $this->belongsTo("App\Gateway",'gw_id','gw_id');
    }


}
