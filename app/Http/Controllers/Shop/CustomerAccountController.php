<?php

namespace App\Http\Controllers\Shop;

use App\Actions\Shop\BuildCustomerDashboardAction;
use App\Actions\Shop\GetCustomerOrderDetailAction;
use App\Actions\Shop\GetCustomerOrdersAction;
use App\Actions\Shop\UpdateCustomerProfileAction;
use App\Http\Controllers\Controller;
use App\Models\SalesOrder;
use App\Models\User;
use App\Services\CatalogOptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CustomerAccountController extends Controller
{
    public function __construct(
        private readonly CatalogOptionService $catalogOptionService,
        private readonly BuildCustomerDashboardAction $buildCustomerDashboardAction,
        private readonly GetCustomerOrdersAction $getCustomerOrdersAction,
        private readonly GetCustomerOrderDetailAction $getCustomerOrderDetailAction,
        private readonly UpdateCustomerProfileAction $updateCustomerProfileAction
    ) {
    }

    public function index(): View
    {
        $user = Auth::user();
        if (!$user instanceof User) {
            abort(401);
        }

        $dashboard = $this->buildCustomerDashboardAction->execute($user);

        return view('shop.account.index', [
            'user' => $user,
            'recentOrders' => $dashboard['recentOrders'],
            'totalOrders' => $dashboard['totalOrders'],
            'totalSpent' => $dashboard['totalSpent'],
        ]);
    }

    public function orders(): View
    {
        $orders = $this->getCustomerOrdersAction->execute((int) Auth::id(), 10);

        return view('shop.account.orders', compact('orders'));
    }

    public function orderDetail(SalesOrder $order): View
    {
        $resolvedOrder = $this->getCustomerOrderDetailAction->execute($order, (int) Auth::id());
        if (!$resolvedOrder) {
            abort(403);
        }

        return view('shop.account.order-detail', ['order' => $resolvedOrder]);
    }

    public function profile(): View
    {
        $user = Auth::user();
        if (!$user instanceof User) {
            abort(401);
        }

        $documentTypes = $this->catalogOptionService->options('cliente_tipo_documento', [
            ['numero' => 1, 'descripcion' => 'Cedula', 'siglas' => 'CED'],
            ['numero' => 2, 'descripcion' => 'RUC', 'siglas' => 'RUC'],
            ['numero' => 3, 'descripcion' => 'Pasaporte', 'siglas' => 'PAS'],
            ['numero' => 4, 'descripcion' => 'Otro', 'siglas' => 'OTR'],
        ]);

        return view('shop.account.profile', [
            'user' => $user,
            'documentTypes' => $documentTypes,
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();
        if (!$user) {
            abort(401);
        }
        /** @var User $user */

        $documentTypeSiglas = $this->catalogOptionService->keys('cliente_tipo_documento', ['CED', 'RUC', 'PAS', 'OTR']);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'document_type' => ['nullable', Rule::in($documentTypeSiglas)],
            'document_number' => 'nullable|string|max:20',
        ]);

        $this->updateCustomerProfileAction->execute($user, $data);

        return back()->with('success', 'Perfil actualizado correctamente');
    }
}
