<turbo-frame id="admin-content">
    <x-turbo-alert type="success" :dismissible="false">
        {{ $message }}
    </x-turbo-alert>

    @if(!empty($redirectUrl))
        <script>
            setTimeout(() => {
                Turbo.visit(@js($redirectUrl), { frame: 'admin-content' });
            }, 600);
        </script>
    @endif
</turbo-frame>
