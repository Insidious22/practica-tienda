<?php

namespace App\Services;

use Illuminate\Http\Response;

class TurboFrameResponder
{
    public function frame(
        string $view,
        array $data = [],
        ?string $frameId = null,
        array $headers = []
    ): Response {
        $resolvedFrameId = $frameId ?? TurboService::frameId() ?? 'main-content';

        $response = response()
            ->view($view, $data)
            ->header('Turbo-Frame', $resolvedFrameId);

        foreach ($headers as $header => $value) {
            $response->header($header, $value);
        }

        return $response;
    }

    public function redirect(string $url, ?string $frameId = null): Response
    {
        $resolvedFrameId = $frameId ?? TurboService::frameId() ?? 'main-content';

        return TurboService::redirect($url)
            ->header('Turbo-Frame', $resolvedFrameId);
    }
}
