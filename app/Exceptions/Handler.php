<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use App\Utilities\Helpers;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        
    }

    public function render($request, Throwable $exception)
    {
        $env = config('app.env');
        if ($exception instanceof Exception && !($exception instanceof AuthenticationException)) {
            $code = $exception->getCode();
            if ($code == 0) $code = 500;
            return (new Helpers())->errorResponder(null, $code, $exception->getMessage());
        }
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if($request->expectsJson()){
           return  (new Helpers)->errorResponder(null, 401 , 'Unauthorized');
        }
        return redirect()->guest('login');
    }
}
