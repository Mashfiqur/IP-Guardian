<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler {

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
     * A list of the exception types for which default rendering method will be applied
     *
     * @var array
     */
    protected $renderDefault = [
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Response to send for handling Exception
     *
     * @var object
     */
    protected $response;


    /**
     * @param Illuminate\Contracts\Routing\ResponseFactory $response
     */
    public function __construct(ResponseFactory $response)
    {
        $this->response = $response;
    }

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
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
        
        return $this->response->json([
            'message' => 'Too Many Attempts. Please try again in ' . $retryAfter . ' seconds.'
        ], 429);
    }

    protected function handleAuthenticationException(AuthenticationException $exception)
    {
        return $this->response->json([
            'message' => 'Authentication failed. Please login.'
        ], 401);
    }

    protected function handleModelNotFoundException(ModelNotFoundException $exception)
    {
        return $this->response->json([
            'message' => 'Sorry, the requested item could not be found.'
        ], 404);
    }

    protected function handleHttpExecption(HttpException $exception)
    {
        return $this->response->json([
            'message' => $exception->getMessage()
        ], $exception->getStatusCode());
    }

    protected function handleProductionError()
    {
        return $this->response->json([
            'message' => 'Unhandled system error has occurred',
        ], 500);
    }  
}