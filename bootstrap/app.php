<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(\App\Http\Middleware\HandleTurboRequest::class);

        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
            'customer' => \App\Http\Middleware\EnsureUserIsCustomer::class,
            'admin.or.superadmin' => \App\Http\Middleware\EnsureUserIsAdminOrSuperAdmin::class,
        ]);

        // Redirigir usuarios no autenticados al login correcto según contexto
        $middleware->redirectGuestsTo(fn (Request $request) =>
            $request->is('admin/*') ? '/admin/login' : '/tienda/login'
        );

        // Redirigir usuarios autenticados al dashboard correcto (evita que admin vaya a la tienda)
        $middleware->redirectUsersTo(fn (Request $request) =>
            $request->is('admin/*') ? '/admin/dashboard' : '/'
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Manejar 419 Page Expired (CSRF token expirado) de forma amigable
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, Request $request) {
            return redirect($request->url())
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'La página expiró. Por favor intenta de nuevo.');
        });
    })->create();
