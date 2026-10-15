<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\EntregaEpp;
use Illuminate\Http\Request;

class firmaEpp extends Controller
{
    public function index($usuario)
    {
        $emple = Empleado::where('id', $usuario)->get();
        return view('firmaEpp', compact('emple'));
    }

    public function update(Request $request, $id)
    {
        $entrega = EntregaEpp::where('empleado_id', $id)->get();
        $image_parts = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $filename = uniqid() . '.' . $image_type;
        file_put_contents(public_path('signatures/' . $filename), $image_base64);

        foreach ($entrega as $item) {
            if ($item->firma == null) {
                $epp = $item;
                $epp->firma = 'signatures/' . $filename;
                $epp->update();
            }
        }

        return redirect()->route('entrega')->with('info', 'El registro de la firma para el epp fue exitoso!');
    }
}
