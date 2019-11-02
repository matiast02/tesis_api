<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Measure extends Model {

    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [ "dst", "ptype", "src", "seq", "len", "snr", "rssi", "bw", "cr", "sf", "tdata", "tc", "pa", "co", "hu","hi", ];

    protected $dates = [];

    public static $rules = [

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
        "hi" => "numeric",
    ];

    public $timestamps = true;


    public function nodo()
    {
        return $this->belongsTo("App\Nodos", "src", "src");
    }


}