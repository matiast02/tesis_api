<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Gateway extends Model {

    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = ["gw_id", "lat", "long", "freq", "nombre"];

    protected $dates = [];

    public static $rules = [
        "gw_id" => "required|min:8",
        "freq" => "numeric|required",
        "nombre" => "string|min:3|max:300",
    ];

    public $timestamps = false;

    // Relationships

}
