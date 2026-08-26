<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        // $this->reportable(function (Throwable $e) {
        //     //
        // });
        $this->renderable(function (HttpException $exception, $request) {
            if ($request->routeIs('admin.*')) {
                if ($this->isHttpException($exception)) {
                    if ($exception->getStatusCode() == 404) {
                        return response()->view('admin.errors.404', [], 404);
                    }
                    if ($exception->getStatusCode() == 403) {
                        return response()->view('admin.errors.403', [], 403);
                    }
                }
            }
        });
    }
}
