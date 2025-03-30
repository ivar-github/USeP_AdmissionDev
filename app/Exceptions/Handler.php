<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Session\TokenMismatchException;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param  Throwable  $exception
     * @return Response
     */
    public function render($request, Throwable $exception)
    {

        if ($exception instanceof NotFoundHttpException) {
            return response()->view('Errors.404', [], 404);
        }

        if ($exception instanceof HttpException && $exception->getStatusCode() == 500) {
            return response()->view('Errors.500', [], 500);
        }

        if ($exception instanceof TokenMismatchException) {
            return response()->view('Errors.419', [], 419);
        }

        if ($exception instanceof HttpException && $exception->getStatusCode() == 503) {
            return response()->view('Errors.503', [], 503);
        }

        return parent::render($request, $exception);
    }
}
