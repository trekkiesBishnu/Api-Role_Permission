<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\AuthenticationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        $this->renderable(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
            return response()->json([
                'error' => [
                    'message' => 'You do not have the required authorization.',
                    'status' => 403,
                ],
            ]);
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            'error' => [
                'status' => 401,
                'message' => 'Unauthenticated',
            ],
        ]);
    }
}
