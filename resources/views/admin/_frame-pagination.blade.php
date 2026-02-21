@if($paginator->hasPages())
    <nav class="admin-table-pagination" aria-label="Paginacion">
        <ul class="pagination">
            <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                @if($paginator->onFirstPage())
                    <span class="page-link">Anterior</span>
                @else
                    <a
                        class="page-link"
                        href="{{ $paginator->previousPageUrl() }}"
                        data-turbo-frame="{{ $frameId }}"
                        data-turbo-action="advance"
                    >
                        Anterior
                    </a>
                @endif
            </li>

            @foreach($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                <li class="page-item {{ $page === $paginator->currentPage() ? 'active' : '' }}">
                    <a
                        class="page-link"
                        href="{{ $url }}"
                        data-turbo-frame="{{ $frameId }}"
                        data-turbo-action="advance"
                    >
                        {{ $page }}
                    </a>
                </li>
            @endforeach

            <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
                @if($paginator->hasMorePages())
                    <a
                        class="page-link"
                        href="{{ $paginator->nextPageUrl() }}"
                        data-turbo-frame="{{ $frameId }}"
                        data-turbo-action="advance"
                    >
                        Siguiente
                    </a>
                @else
                    <span class="page-link">Siguiente</span>
                @endif
            </li>
        </ul>
    </nav>
@endif
