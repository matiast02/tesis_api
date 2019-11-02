<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Nodo extends Model {

    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [ "lat", "long", "freq", "src", "nombre", "gw_id"];

    protected $dates = [];

    public static $rules = [
        "gw_id" => "required",
        "freq" => "numeric|required",
        "src" => "numeric|required",
        "nombre" => "string|min:3|max:300",
    ];

    public $timestamps = true;

    public function gateway()
    {
        return $this->belongsTo("App\Gateway",'gw_id','gw_id');
    }

    public function measures()
    {
        return $this->hasMany("App\Measure", "src", "src");
    }


}
