<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if( $request->wantsJson() ){
            return response()->json(
                $this->getJsonMessage($exception), 
                $this->getExceptionHTTPStatusCode($exception)
            );
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }

    /**
     * Format a JSON message out of an exception
     *
     * @param $e Exception
     * @return array
     */
    protected function getJsonMessage($e){
        return [
            'status' => 'false',
            'message' => $e->getMessage()
        ];
    }

    /**
     * Determine the HTTP Status code for an exception
     *
     * @param $e Exception
     * @return integer HTTP Status Code
     */
    protected function getExceptionHTTPStatusCode($e){
        // Not all Exceptions have a http status code
        // We will give Error 500 if none found
        return method_exists($e, 'getStatusCode') ? 
                         $e->getStatusCode() : 500;
    }
}
