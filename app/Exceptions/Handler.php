<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception) 
    {
        if ($exception instanceof ThrottleRequestsException) {
            return $this->handleThrottleRequestsException($exception);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->handleAuthenticationException($exception);
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->handleModelNotFoundException($exception);
        }

        // In future logging must be handled in effiecient way.
        Log::error($exception);

        if($exception instanceof HttpException){
            return $this->handleHttpExecption($exception);
        }

        return config('app.env') === 'production'
            ? $this->handleProductionError()
            : parent::render($request, $exception);
    }

    protected function handleThrottleRequestsException(ThrottleRequestsException $exception)
    {
        $retryAfter = $exception->getHeaders()['Retry-After'] ?? 60;
        
        return response()->json([
            'message' => 'Too Many Attempts. Please try again in ' . $retryAfter . ' seconds.'
        ], 429);
    }

    protected function handleAuthenticationException(AuthenticationException $exception)
    {
        return response()->json([
            'message' => 'Authentication failed. Please login.'
        ], 401);
    }

    protected function handleModelNotFoundException(ModelNotFoundException $exception)
    {
        return response()->json([
            'message' => 'Sorry, the requested item could not be found.'
        ], 404);
    }

    protected function handleHttpExecption(HttpException $exception)
    {
        return response()->json([
            'message' => $exception->getMessage()
        ], $exception->getStatusCode());
    }

    protected function handleProductionError()
    {
        return response()->json([
            'message' => 'Unhandled system error has occurred',
        ], 500);
    }  
}