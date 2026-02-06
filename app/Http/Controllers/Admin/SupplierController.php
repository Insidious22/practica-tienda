<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::orderByDesc('id')->paginate(15);
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(Request $request)
    {
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
            'status' => 'required|in:active,inactive',
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
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
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
            'status' => 'required|in:active,inactive',
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
