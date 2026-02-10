<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function destroy(string $id)
    {
        $item = Item::with('inventarioItem')->findOrFail($id);
        $guardiaId = $item->guardia_id;

        DB::transaction(function () use ($item) {
            if ($item->inventarioItem) {
                $item->inventarioItem->increment('cantidad');
            }
            $item->delete();
        });

        return redirect()->route('admin.guardias.show', $guardiaId)
            ->with('success', 'Item removido correctamente. Cantidad devuelta al inventario.');
    }
}