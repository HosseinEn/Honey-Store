<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Route as FacadesRoute;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        // $this->renderable(function (Exception $e, $request) {
        //     // dd("ada");
        //     // dd($request->expectsJson());
        //     if($request->expectsJson() && $e instanceof NotFoundHttpException){
        //         return Route::respondWithRoute('api.fallback');
        //     }
        // });

        // $this->renderable(function (NotFoundHttpException $e, $request) {
        //     if ($request->is('api/*') && $request->expectsJson()) {
        //         return FacadesRoute::respondWithRoute('api.fallback');
        //     }
        // });
    }
}
