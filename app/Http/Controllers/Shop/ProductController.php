<?php

namespace App\Http\Controllers\Shop;

use App\Actions\Shop\AddProductToCartAction;
use App\Actions\Shop\BuildRelatedProductsQueryAction;
use App\Actions\Shop\BuildTurboCatalogQueryAction;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CartService;
use App\Services\TurboFrameResponder;
use App\Services\TurboService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly AddProductToCartAction $addProductToCartAction,
        private readonly BuildTurboCatalogQueryAction $buildTurboCatalogQueryAction,
        private readonly BuildRelatedProductsQueryAction $buildRelatedProductsQueryAction,
        private readonly TurboFrameResponder $turboFrameResponder,
    ) {
    }

    public function getCatalog(Request $request): Response
    {
        $frameId = TurboService::frameId() ?? 'main-content';
        $query = $this->buildTurboCatalogQueryAction->execute($request);

        $hasFilters = $request->filled('search')
            || $request->filled('category')
            || $request->filled('max_price');

        if (! $hasFilters) {
            $cacheKey = 'turbo.catalog.default.page.' . max(1, (int) $request->query('page', 1));

            $html = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($query, $frameId) {
                $products = (clone $query)->orderByDesc('created_at')->paginate(12)->withQueryString();

                return view('shop.frames.catalog', [
                    'products' => $products,
                    'turboFrame' => $frameId,
                ])->render();
            });

            return response($html)
                ->header('Turbo-Frame', $frameId)
                ->header('Cache-Control', 'private, max-age=300');
        }

        $products = $query->orderByDesc('created_at')->paginate(12)->withQueryString();

        return $this->turboFrameResponder->frame(
            'shop.frames.catalog',
            [
                'products' => $products,
                'turboFrame' => $frameId,
            ],
            $frameId,
            ['Cache-Control' => 'private, max-age=300']
        ); // 5 minutos
    }

    public function show(Product $product): Response
    {
        if ($product->status !== 'ACT') {
            abort(404);
        }

        $relatedProducts = $this->buildRelatedProductsQueryAction
            ->execute($product)
            ->limit(4)
            ->get();

        $frameId = TurboService::frameId() ?? 'main-content';

        return $this->turboFrameResponder->frame(
            'shop.frames.product',
            [
                'product' => $product->load('category'),
                'relatedProducts' => $relatedProducts,
                'turboFrame' => $frameId,
            ],
            $frameId
        );
    }

    public function getCart(): Response
    {
        $cart = $this->cartService->getCart()->load('items.product.category');
        $frameId = TurboService::frameId() ?? 'main-content';

        return $this->turboFrameResponder->frame(
            'shop.frames.cart',
            [
                'cart' => $cart,
                'turboFrame' => $frameId,
            ],
            $frameId
        );
    }

    public function addToCart(Request $request): Response
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
        ]);

        $result = $this->addProductToCartAction->execute(
            (int) $data['product_id'],
            (float) $data['quantity']
        );

        if ($result->isUnavailable()) {
            return $this->turboFrameResponder->frame(
                'shop.frames.cart-updated',
                [
                    'type' => 'danger',
                    'message' => 'Producto no disponible.',
                    'nextUrl' => route('content.catalog'),
                ]
            );
        }

        if ($result->isInsufficientStock()) {
            return $this->turboFrameResponder->frame(
                'shop.frames.cart-updated',
                [
                    'type' => 'warning',
                    'message' => 'Stock insuficiente para este producto.',
                    'nextUrl' => route('content.product', $result->product),
                ]
            );
        }

        return $this->turboFrameResponder->frame(
            'shop.frames.cart-updated',
            [
                'type' => 'success',
                'message' => "'{$result->product->name}' agregado al carrito.",
                'nextUrl' => route('content.cart'),
            ]
        );
    }
}
