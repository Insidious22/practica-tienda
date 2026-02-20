<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Diccionario;
use App\Models\SalesOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class CustomerAccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $recentOrders = SalesOrder::where('user_id', $user->id)
            ->where('channel', 'online')
            ->latest()
            ->limit(5)
            ->get();

        $totalOrders = SalesOrder::where('user_id', $user->id)
            ->where('channel', 'online')
            ->count();

        $totalSpent = SalesOrder::where('user_id', $user->id)
            ->where('channel', 'online')
            ->where('status', 'completed')
            ->sum('total');

        return view('shop.account.index', compact('user', 'recentOrders', 'totalOrders', 'totalSpent'));
    }

    public function orders()
    {
        $orders = SalesOrder::where('user_id', Auth::id())
            ->where('channel', 'online')
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('shop.account.orders', compact('orders'));
    }

    public function orderDetail(SalesOrder $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items.product', 'payments']);

        return view('shop.account.order-detail', compact('order'));
    }

    public function profile()
    {
        $documentTypes = $this->obtenerCatalogo('cliente_tipo_documento', [
            ['numero' => 1, 'descripcion' => 'Cedula', 'siglas' => 'CED'],
            ['numero' => 2, 'descripcion' => 'RUC', 'siglas' => 'RUC'],
            ['numero' => 3, 'descripcion' => 'Pasaporte', 'siglas' => 'PAS'],
            ['numero' => 4, 'descripcion' => 'Otro', 'siglas' => 'OTR'],
        ]);

        return view('shop.account.profile', ['user' => Auth::user(), 'documentTypes' => $documentTypes]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            abort(401);
        }
        /** @var User $user */

        $documentTypeSiglas = $this->obtenerSiglasCatalogo('cliente_tipo_documento', ['CED', 'RUC', 'PAS', 'OTR']);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'document_type' => ['nullable', Rule::in($documentTypeSiglas)],
            'document_number' => 'nullable|string|max:20',
        ]);

        $user->update($data);

        return back()->with('success', 'Perfil actualizado correctamente');
    }

    private function obtenerCatalogo(string $tipo, array $fallback): Collection
    {
        $catalogo = Diccionario::porTipo($tipo)->orderBy('orden')->get();

        if ($catalogo->isNotEmpty()) {
            return $catalogo->map(function ($item) {
                return (object) [
                    'numero' => (int) ($item->numero ?? $item->orden ?? 0),
                    'descripcion' => trim((string) ($item->descripcion ?? '')),
                    'siglas' => strtoupper(trim((string) ($item->siglas ?? $item->valor ?? ''))),
                ];
            })->filter(fn ($item) => $item->siglas !== '' && $item->descripcion !== '')->values();
        }

        return collect($fallback)->map(function ($item) {
            return (object) [
                'numero' => (int) ($item['numero'] ?? 0),
                'descripcion' => trim((string) ($item['descripcion'] ?? '')),
                'siglas' => strtoupper(trim((string) ($item['siglas'] ?? ''))),
            ];
        })->values();
    }

    private function obtenerSiglasCatalogo(string $tipo, array $fallback): array
    {
        $siglas = collect(Diccionario::siglas($tipo))
            ->map(fn ($sigla) => strtoupper(trim((string) $sigla)))
            ->filter()
            ->unique()
            ->values()
            ->all();

        if (!empty($siglas)) {
            return $siglas;
        }

        return collect($fallback)
            ->map(fn ($sigla) => strtoupper(trim((string) $sigla)))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}

