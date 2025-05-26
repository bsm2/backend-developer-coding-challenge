<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Http\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponser;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                if ($e instanceof AccessDeniedHttpException) {
                    return $this->error(__('main.unauthorized'), $e->getStatusCode());
                }
                if ($e instanceof ModelNotFoundException) {
                    return $this->error(__('main.page_not_found'), 422, $e->getModel());
                }
                if ($e instanceof NotFoundHttpException) {
                    $msg = explode(']', class_basename($e->getMessage()))[0] == null
                        ? null
                        : explode(']', class_basename($e->getMessage()))[0] . ' ';
                    return $this->error(__('main.page_not_found'), $e->getStatusCode(), []);
                }
                if ($e instanceof HttpException && $e->getStatusCode() == 403) {
                    return  $this->error(__('main.unauthorized'), 403, $e->getMessage());
                }
                if ($e instanceof  MethodNotAllowedHttpException) {
                    return  $this->error(__('main.not_supported_method'), 405, $e->getMessage());
                }
                if ($e instanceof QueryException) {
                    $code = $e->errorInfo[1];
                    if ($code == 1451) {
                        return  $this->error(__('main.cannot_remove_this'), 409, $e->getMessage());
                    }
                }
                if ($e instanceof QueryException) {
                    return  $this->error(__('main.error_happend'), 409, $e->getMessage());
                }
            }
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return $this->error(__('main.unauthenticated'), 401);
        }
    }
}
