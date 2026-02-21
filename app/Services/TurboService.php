<?php

namespace App\Services;

class TurboService
{
    public static function isTurboRequest(): bool
    {
        return request()->header('Turbo-Frame') !== null
            || request()->header('X-Turbo-Request') !== null
            || request()->routeIs('content.*')
            || request()->routeIs('admin.products.*');
    }

    public static function frameId(): ?string
    {
        return request()->header('Turbo-Frame');
    }

    public static function redirect(string $url)
    {
        return response(null, 200)->header('Turbo-Location', $url);
    }
}
