<turbo-frame id="admin-content">
    <div class="header">
        <h1 class="title">{{ isset($product) ? 'Editar Producto' : 'Nuevo Producto' }}</h1>
    </div>

    <form
        action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
        method="POST"
        class="product-form-card needs-validation"
        novalidate
    >
        @csrf
        @if(isset($product))
            @method('PATCH')
        @endif

        @include('products._form', ['product' => $product ?? null])
    </form>
</turbo-frame>
