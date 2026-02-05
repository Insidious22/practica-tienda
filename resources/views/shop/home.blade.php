@extends('layouts.shop')

@section('content')
    <!-- Hero Section -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 60px 40px; margin-bottom: 40px; color: white; text-align: center;">
        <h1 style="font-size: 36px; font-weight: 700; margin-bottom: 15px;">Bienvenido a Rafatones</h1>
        <p style="font-size: 18px; opacity: 0.9; margin-bottom: 25px;">Encuentra los mejores productos a los mejores precios</p>
        <a href="{{ route('shop.catalog') }}" class="btn" style="background: white; color: #667eea; padding: 14px 30px; font-size: 16px;">
            Ver Catalogo
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
            </svg>
        </a>
    </div>

    <!-- Categories -->
    @if($categories->count() > 0)
        <section style="margin-bottom: 50px;">
            <h2 style="font-size: 24px; font-weight: 700; margin-bottom: 20px;">Categorias</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 15px;">
                @foreach($categories as $category)
                    <a href="{{ route('shop.category', $category) }}" style="background: white; padding: 20px; border-radius: 12px; text-decoration: none; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.06); transition: all 0.3s;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; margin: 0 auto 12px; display: flex; align-items: center; justify-content: center;">
                            <svg fill="none" stroke="white" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <h3 style="font-size: 14px; font-weight: 600; color: #1f2937; margin-bottom: 4px;">{{ $category->name }}</h3>
                        <span style="font-size: 12px; color: #6b7280;">{{ $category->products_count }} productos</span>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Featured Products -->
    <section>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="font-size: 24px; font-weight: 700;">Productos Destacados</h2>
            <a href="{{ route('shop.catalog') }}" style="color: #667eea; text-decoration: none; font-weight: 500; display: flex; align-items: center; gap: 5px;">
                Ver todos
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        @if($featuredProducts->count() > 0)
            <div class="product-grid">
                @foreach($featuredProducts as $product)
                    @include('shop._product-card', ['product' => $product])
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 12px;">
                <p style="color: #6b7280; font-size: 16px;">No hay productos disponibles en este momento.</p>
            </div>
        @endif
    </section>
@endsection
