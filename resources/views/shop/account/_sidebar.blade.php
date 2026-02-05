<div class="card" style="position: sticky; top: 100px;">
    <div class="card-body" style="padding: 0;">
        <nav style="display: flex; flex-direction: column;">
            <a href="{{ route('shop.account.index') }}"
               style="padding: 15px 20px; text-decoration: none; color: {{ Route::currentRouteName() === 'shop.account.index' ? '#667eea' : '#4b5563' }}; border-left: 3px solid {{ Route::currentRouteName() === 'shop.account.index' ? '#667eea' : 'transparent' }}; background: {{ Route::currentRouteName() === 'shop.account.index' ? '#f3f4f6' : 'transparent' }}; display: flex; align-items: center; gap: 12px;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-4 7 4M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('shop.account.orders') }}"
               style="padding: 15px 20px; text-decoration: none; color: {{ str_starts_with(Route::currentRouteName(), 'shop.account.orders') ? '#667eea' : '#4b5563' }}; border-left: 3px solid {{ str_starts_with(Route::currentRouteName(), 'shop.account.orders') ? '#667eea' : 'transparent' }}; background: {{ str_starts_with(Route::currentRouteName(), 'shop.account.orders') ? '#f3f4f6' : 'transparent' }}; display: flex; align-items: center; gap: 12px;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Mis Pedidos
            </a>
            <a href="{{ route('shop.account.profile') }}"
               style="padding: 15px 20px; text-decoration: none; color: {{ Route::currentRouteName() === 'shop.account.profile' ? '#667eea' : '#4b5563' }}; border-left: 3px solid {{ Route::currentRouteName() === 'shop.account.profile' ? '#667eea' : 'transparent' }}; background: {{ Route::currentRouteName() === 'shop.account.profile' ? '#f3f4f6' : 'transparent' }}; display: flex; align-items: center; gap: 12px;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Mi Perfil
            </a>
            <form action="{{ route('shop.logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="width: 100%; padding: 15px 20px; text-align: left; border: none; background: none; cursor: pointer; color: #ef4444; display: flex; align-items: center; gap: 12px; font-size: inherit; font-family: inherit;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Cerrar Sesion
                </button>
            </form>
        </nav>
    </div>
</div>
