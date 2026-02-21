<turbo-frame id="{{ $turboFrame ?? 'main-content' }}">
    <x-turbo-alert :type="$type ?? 'success'" :dismissible="false">
        {{ $message ?? 'Accion completada.' }}
    </x-turbo-alert>

    <div class="mt-3 d-flex gap-2">
        <a href="{{ $nextUrl ?? route('content.cart') }}" class="btn btn-primary" data-turbo-frame="{{ $turboFrame ?? 'main-content' }}">
            Continuar
        </a>
        <a href="{{ route('content.catalog') }}" class="btn btn-outline-secondary" data-turbo-frame="{{ $turboFrame ?? 'main-content' }}">
            Seguir comprando
        </a>
    </div>
</turbo-frame>
