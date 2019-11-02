<?php namespace App;

use Illuminate\Database\Eloquent\Model;



class Gateway extends Model
{

    use \Illuminate\Database\Eloquent\SoftDeletes;
//    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

    protected $fillable = ["gw_id", "lat", "long", "freq", "nombre"];

    protected $dates = ['deleted_at'];
//    protected $softCascade = ['nodos'];

    public static $rules = [
        "gw_id" => "required|min:8",
        "freq" => "numeric|required",
        "nombre" => "string|min:3|max:300",
    ];

    public $timestamps = true;

    // Relationships

    public function nodos()
    {
        return $this->hasMany(Nodo::class, 'gw_id', 'gw_id');
    }



}
