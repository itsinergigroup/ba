<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\CheckActive::class,
        ]);
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Database\QueryException $e, Request $request) {
            if ($e->getCode() == "23000" && str_contains($e->getMessage(), 'Cannot delete or update a parent row')) {
                return redirect()->back()
                    ->with('error', 'Data tidak dapat dihapus karena masih digunakan oleh data lain.');
            }
        });
        $exceptions->render(function (TokenMismatchException $e, Request $request) {
            return redirect()->back()
                ->withInput($request->except('_token'))
                ->with('error', 'Sesi halaman Anda telah berakhir. Silakan coba simpan kembali.');
        });
    })->create();
