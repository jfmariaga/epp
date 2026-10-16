<?php

namespace App\Http\Controllers;

use App\Models\EntregaEpp;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReporteExportController extends Controller
{
    public function export(Request $request): StreamedResponse
    {
        $search = $request->query('search');

        $reportes = EntregaEpp::query()
            ->with(['empleado', 'epp'])
            ->when($search, function ($query) use ($search) {
                $term = '%' . $search . '%';
                $query->whereHas('empleado', function ($q) use ($term) {
                    $q->where('nombre', 'like', $term)
                        ->orWhere('cc', 'like', $term);
                });
            })
            ->latest('fechaEntrega')
            ->cursor();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="reporte-entregas.csv"',
        ];

        return response()->streamDownload(function () use ($reportes) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Nombre', 'Cedula', 'T. Contrato', 'Centro de costos', 'Area',
                'Item EPP', 'EPP entregado', 'Motivo', 'Labor', 'Linea',
                'Responsable', 'Fecha de entrega',
            ]);

            foreach ($reportes as $item) {
                fputcsv($handle, [
                    $item->empleado->nombre,
                    $item->empleado->cc,
                    $item->empleado->tp_contrato,
                    $item->empleado->centro,
                    $item->empleado->area,
                    $item->epp->item,
                    $item->epp->descripcion,
                    $item->motivo,
                    $item->empleado->cargo,
                    $item->linea,
                    $item->responsable,
                    $item->fechaEntrega,
                ]);
            }

            fclose($handle);
        }, 'reporte-entregas.csv', $headers);
    }
}
