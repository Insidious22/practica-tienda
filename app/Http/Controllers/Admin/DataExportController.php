<?php

namespace App\Http\Controllers\Admin;

use App\Exports\GenericQueryExport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel as ExcelWriter;
use Maatwebsite\Excel\Facades\Excel;

class DataExportController extends Controller
{
    public function export(Request $request)
    {
        $data = $request->validate([
            'dataset' => 'required|in:categorias,productos,zonas,proveedores,usuarios,clientes',
            'format' => 'nullable|in:csv,xlsx',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $this->authorizeDataset($request, $data['dataset']);

        $startDate = Carbon::parse($data['start_date'])->startOfDay();
        $endDate = Carbon::parse($data['end_date'])->endOfDay();
        $format = $data['format'] ?? 'csv';

        $export = new GenericQueryExport(
            $data['dataset'],
            $startDate->toDateTimeString(),
            $endDate->toDateTimeString()
        );

        $filename = sprintf(
            '%s_%s_a_%s_%s.%s',
            $data['dataset'],
            $startDate->format('Ymd'),
            $endDate->format('Ymd'),
            now()->format('His'),
            $format
        );

        $writerType = $format === 'xlsx' ? ExcelWriter::XLSX : ExcelWriter::CSV;

        return Excel::download($export, $filename, $writerType);
    }

    private function authorizeDataset(Request $request, string $dataset): void
    {
        if ($dataset === 'usuarios' && !$request->user()?->isSuperAdmin()) {
            abort(403, 'No tienes permiso para exportar este modulo.');
        }
    }
}
