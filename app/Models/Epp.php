<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Epp extends Model
{
    protected $fillable = ['descripcion','item','acta'];
    public $timestamps = false;

    use HasFactory;

    public function entregasEpps (){
        return $this->hasMany(EntregaEpp::class);
    }
}
