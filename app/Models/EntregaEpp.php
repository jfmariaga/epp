<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaEpp extends Model
{
    protected $fillable = ['empleado_id','motivo','responsable','fechaEntrega','epp_id','firma','linea','observacion'];

    use HasFactory;

    public function empleado(){
        return $this->belongsTo(Empleado::class);
    }

    public function epp (){
        return $this->belongsTo(Epp::class);
    }
}
