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
        $folderPath = public_path('signatures/'); // create signatures folder in public directory
        $image_parts = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . uniqid() . '.' . $image_type;
        file_put_contents($file, $image_base64);

        foreach ($entrega as $item) {
            if ($item->firma == null) {
                $epp = $item;
                $epp->firma = $file;
                $epp->update();
            }
        }

        return redirect()->route('entrega')->with('info', 'El registro de la firma para el epp fue exitoso!');
    }
}
