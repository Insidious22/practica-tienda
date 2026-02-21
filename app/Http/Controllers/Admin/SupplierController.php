<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Services\CatalogOptionService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function __construct(private readonly CatalogOptionService $catalogOptionService)
    {
    }

    public function index()
    {
        $suppliers = Supplier::orderByDesc('id')->paginate(15);
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        $statusOptions = $this->catalogOptionService->options('proveedor_estado', [
            ['numero' => 1, 'descripcion' => 'Activo', 'siglas' => 'ACT'],
            ['numero' => 2, 'descripcion' => 'Inactivo', 'siglas' => 'INA'],
        ]);

        return view('admin.suppliers.create', compact('statusOptions'));
    }

    public function store(Request $request)
    {
        $statusSiglas = $this->catalogOptionService->keys('proveedor_estado', ['ACT', 'INA']);

        $data = $request->validate([
            'code' => 'required|string|max:32|unique:suppliers,code',
            'business_name' => 'required|string|max:255',
            'trade_name' => 'nullable|string|max:255',
            'contact_name' => 'nullable|string|max:128',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:32',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:128',
            'tax_id' => 'nullable|string|max:32',
            'payment_terms' => 'nullable|string|max:128',
            'notes' => 'nullable|string',
            'status' => ['required', Rule::in($statusSiglas)],
        ]);

        Supplier::create($data);

        return redirect()->route('admin.proveedores.index')
            ->with('success', 'Proveedor creado correctamente.');
    }

    public function show(Supplier $supplier)
    {
        $supplier->load('products', 'purchaseOrders');
        return view('admin.suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        $statusOptions = $this->catalogOptionService->options('proveedor_estado', [
            ['numero' => 1, 'descripcion' => 'Activo', 'siglas' => 'ACT'],
            ['numero' => 2, 'descripcion' => 'Inactivo', 'siglas' => 'INA'],
        ]);

        return view('admin.suppliers.edit', compact('supplier', 'statusOptions'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $statusSiglas = $this->catalogOptionService->keys('proveedor_estado', ['ACT', 'INA']);

        $data = $request->validate([
            'code' => 'required|string|max:32|unique:suppliers,code,' . $supplier->id,
            'business_name' => 'required|string|max:255',
            'trade_name' => 'nullable|string|max:255',
            'contact_name' => 'nullable|string|max:128',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:32',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:128',
            'tax_id' => 'nullable|string|max:32',
            'payment_terms' => 'nullable|string|max:128',
            'notes' => 'nullable|string',
            'status' => ['required', Rule::in($statusSiglas)],
        ]);

        $supplier->update($data);

        return redirect()->route('admin.proveedores.index')
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(Supplier $supplier)
    {
        if ($supplier->purchaseOrders()->exists()) {
            return back()->with('error', 'No puedes eliminar este proveedor porque tiene órdenes de compra asociadas.');
        }

        $supplier->delete();

        return redirect()->route('admin.proveedores.index')
            ->with('success', 'Proveedor eliminado correctamente.');
    }
}
