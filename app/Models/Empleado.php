<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable = ['rfid','nombre','centro','cargo','cc','area','estado','tp_contrato'];

    use HasFactory;

    public function entregasEpps(){
        return $this->hasMany(EntregaEpp::class);
    }
}
