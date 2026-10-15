<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\EntregaEpp;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;

class SignaturePadController extends Controller
{
    public function index($usuario)
    {
        $emple = Empleado::where('id', $usuario)->get();
        return view('signature-pad', compact('emple'));
    }

    public function firmaEpp($usuario)
    {
        $emple = Empleado::where('id', $usuario)->get();
        return view('firmaEpp', compact('emple'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Empleado::find($id);
        $folderPath = public_path('signatures/'); // create signatures folder in public directory
        $image_parts = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . uniqid() . '.' . $image_type;
        file_put_contents($file, $image_base64);

        $usuario->update([
            $usuario->firma = $file,

        ]);
        return redirect()->route('empleado', $usuario)->with('info', 'El registro de la firma fue exitoso!');
    }

    public function Addtopdf($id)
    {
        //por medio del ID que viene por GET buscamos la entrega
        $entrega = EntregaEpp::find($id);

        // nueva instancia de FPDI
        $pdf = new Fpdi();


        // agregamos una pagina
        $pdf->AddPage();

        // seleccionamos la fuente y el tamañ de la letra 
        $pdf->SetFont('helvetica', '', '9');

        //  seleccionamos el pdf que se va a sobre escribir tiene que estar en la carpeta public
        $path = public_path("white.pdf");

        // Se establece la ruta 
        $pdf->setSourceFile($path);


        // seleccionamos el numero de paginas que queremos 
        $tplId = $pdf->importPage(1);

        // use la página importada y colóquela en el punto 10,10 con un ancho de 100 mm
        $pdf->useTemplate($tplId, null, null, null, 210, true);

        //empezamos a sobre escribir los datos en el PDF

        // primer valor eje X segundo valor eje Y SetXY(31, 42)
        $pdf->SetXY(31, 42);
        // siempre 0.1 y despues de la coma lo que queremos plasmar en el PDF
        $pdf->Write(0.1, $entrega->empleado->nombre);

        $pdf->SetXY(80, 45);
        $pdf->Write(0.1, $entrega->empleado->cargo);

        $pdf->SetXY(35, 48);
        $pdf->Write(0.1, "Rionegro-Antioquia");

        $pdf->SetXY(105, 48);
        $pdf->Write(0.1, $entrega->fechaEntrega);


        $pdf->SetXY(18, 180);
        $pdf->Image($entrega->empleado->firma, 13, 160, 43, 22);


        // Descarga el PDF en ves de guardarlo en un carpeta si lo quieres guardar cambiar D por F en el primer valor
        // se guardara por defecto en la carpeta public
        $pdf->Output('D', 'ACTA' . $entrega->empleado->cc . '.pdf');
    }

    public function foso32($id)
    {
        //por medio del ID que viene por GET buscamos la entrega
        $trabajador = Empleado::find($id);

        $entrega = EntregaEpp::where('empleado_id', $id)->get();

        // nueva instancia de FPDI
        $pdf = new Fpdi();

        // agregamos una pagina
        $pdf->AddPage();

        // seleccionamos la fuente y el tamañ de la letra 
        $pdf->SetFont('helvetica', '', '6');

        //  seleccionamos el pdf que se va a sobre escribir tiene que estar en la carpeta public
        // $path = public_path("fs32.pdf");
        if ($trabajador->tp_contrato == 'Manpower') {
            $path = public_path("fs32_M.pdf");
        } else if ($trabajador->tp_contrato == 'Ahora') {
            $path = public_path("fs32_A.pdf");
        } else {
            $path = public_path("fs32P1.pdf");
        }

        // Se establece la ruta 
        $pdf->setSourceFile($path);

        // seleccionamos el numero de paginas que queremos 
        $tplId = $pdf->importPage(1);

        // use la página importada y colóquela en el punto 10,10 con un ancho de 100 mm
        $pdf->useTemplate($tplId, null, null, null, 210, true);

        //empezamos a sobre escribir los datos en el PDF

        // primer valor eje X segundo valor eje Y SetXY(31, 42)
        $pdf->SetXY(50, 38);
        // siempre 0.1 y despues de la coma lo que queremos plasmar en el PDF
        $pdf->Write(0.1, $trabajador->nombre);

        $pdf->SetXY(30, 42);
        $pdf->Write(0.1, $trabajador->area);

        $pdf->Image($trabajador->firma, 25, 172, 39, 12);

        $pdf->SetXY(100, 184);
        $pdf->Write(0.1, $trabajador->cc);


        $x = 27;
        $y = 56;
        $r = 54;
        $j = 12;
        $f = 102;
        $m = 69;

        foreach ($entrega as $item) {
            for ($i = 0; $i < 4; $i++) {
                $y += 2;
                $r += 2;
            }
            $pdf->SetXY($x, $y);
            $pdf->Write(0.1, $item->epp->descripcion);
            $pdf->SetXY($j, $y);
            $pdf->Write(0.1, $item->fechaEntrega);
            $pdf->SetXY($m, $y);
            if ($item->linea != null) {
                $pdf->Write(0.1, $item->linea);
            } else {
                $pdf->Write(0.1, 'No registra');
            }
            $pdf->SetXY($f, $y);
            $pdf->Write(0.1, $item->motivo);

            $pdf->Image($item->firma, 128, $r, 25, 4);


            if ($y > 140) {

                $y = 56;
                $r = 54;


                $pdf->AddPage();

                $pdf->SetFont('helvetica', '', '6');

                // $path = public_path("fs32.pdf");
                if ($trabajador->tp_contrato == 'Manpower') {
                    $path = public_path("fs32_M.pdf");
                } else if ($trabajador->tp_contrato == 'Ahora') {
                    $path = public_path("fs32_A.pdf");
                } else {
                    $path = public_path("fs32P1.pdf");
                }

                $pdf->setSourceFile($path);

                $tplId = $pdf->importPage(1);

                $pdf->useTemplate($tplId, null, null, null, 210, true);

                $pdf->SetXY(50, 38);
                $pdf->Write(0.1, $trabajador->nombre);

                $pdf->SetXY(30, 42);
                $pdf->Write(0.1, $trabajador->area);

                $pdf->Image($trabajador->firma, 25, 172, 39, 12);

                $pdf->SetXY(100, 184);
                $pdf->Write(0.1, $trabajador->cc);
            }
        }
        // Descarga el PDF en ves de guardarlo en un carpeta si lo quieres guardar cambiar D por F en el primer valor
        // se guardara por defecto en la carpeta public
        $pdf->Output('D', 'FO-SO-32-' . $trabajador->cc . '.pdf');
    }
}
