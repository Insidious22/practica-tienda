@extends('layouts.shop')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('shop.home') }}">Inicio</a>
        <span class="breadcrumb-separator">/</span>
        <span>Catalogo</span>
    </div>

    <div style="display: grid; grid-template-columns: 250px 1fr; gap: 30px;">
        <!-- Sidebar Filters -->
        <aside>
            <div class="card">
                <div class="card-header">Filtros</div>
                <div class="card-body">
                    <form action="{{ route('shop.catalog') }}" method="GET">
                        <!-- Categories -->
                        <div class="form-group">
                            <label class="form-label">Categoria</label>
                            <select name="category" class="form-input" onchange="this.form.submit()">
                                <option value="">Todas las categorias</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div class="form-group">
                            <label class="form-label">Precio minimo</label>
                            <input type="number" name="min_price" class="form-input" value="{{ request('min_price') }}" placeholder="0" step="0.01">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Precio maximo</label>
                            <input type="number" name="max_price" class="form-input" value="{{ request('max_price') }}" placeholder="1000" step="0.01">
                        </div>

                        <!-- Sort -->
                        <div class="form-group">
                            <label class="form-label">Ordenar por</label>
                            <select name="sort" class="form-input" onchange="this.form.submit()">
                                <option value="newest" @selected(request('sort') == 'newest')>Mas recientes</option>
                                <option value="price_asc" @selected(request('sort') == 'price_asc')>Precio: menor a mayor</option>
                                <option value="price_desc" @selected(request('sort') == 'price_desc')>Precio: mayor a menor</option>
                                <option value="name" @selected(request('sort') == 'name')>Nombre A-Z</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%;">Aplicar filtros</button>

                        @if(request()->hasAny(['category', 'min_price', 'max_price', 'sort']))
                            <a href="{{ route('shop.catalog') }}" class="btn btn-secondary" style="width: 100%; margin-top: 10px;">Limpiar filtros</a>
                        @endif
                    </form>
                </div>
            </div>
        </aside>

        <!-- Products -->
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h1 style="font-size: 24px; font-weight: 700;">Catalogo</h1>
                <span style="color: #6b7280;">{{ $products->total() }} productos encontrados</span>
            </div>

            @if($products->count() > 0)
                <div class="product-grid">
                    @foreach($products as $product)
                        @include('shop._product-card', ['product' => $product])
                    @endforeach
                </div>

                <div class="pagination">
                    {{ $products->links() }}
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center" style="padding: 60px;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 64px; height: 64px; opacity: 0.3; margin: 0 auto 20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <p style="color: #6b7280; font-size: 16px;">No se encontraron productos con los filtros seleccionados.</p>
                        <a href="{{ route('shop.catalog') }}" class="btn btn-primary" style="margin-top: 20px;">Ver todos los productos</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        @media (max-width: 768px) {
            [style*="grid-template-columns: 250px 1fr"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endsection
