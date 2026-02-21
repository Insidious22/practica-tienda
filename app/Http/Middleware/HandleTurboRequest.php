<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleTurboRequest
{
    public function handle(Request $request, Closure $next): Response
    {
        $isTurbo = $request->header('Turbo-Frame')
            || $request->header('X-Turbo-Request')
            || str_contains((string) $request->header('Accept', ''), 'turbo-stream');

        view()->share([
            'isTurbo' => (bool) $isTurbo,
            'turboFrame' => $request->header('Turbo-Frame'),
        ]);

        /** @var Response $response */
        $response = $next($request);

        $response->headers->set('Vary', 'Turbo-Frame, X-Turbo-Request, Accept', false);

        if ($isTurbo) {
            $response->headers->set('Cache-Control', 'no-cache, private');
        }

        if ($isTurbo && $response->isRedirection()) {
            return response('', 200)
                ->header('Turbo-Location', (string) $response->headers->get('Location'));
        }

        return $response;
    }
}
