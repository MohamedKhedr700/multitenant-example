<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * {@inheritDoc}
     */
    public function render($request, Throwable $e): JsonResponse
    {
        $message = $this->renderMessage($e);

        return response()->json([
            'error' => true,
            'message' => $message ?: $e->getMessage(),
            'trace' => $e->getTrace(),
        ]);
    }

    /**
     * Render error message.
     */
    private function renderMessage(Throwable $e): ?string
    {
        return match (true) {
            $e instanceof NotFoundHttpException => trans('messages.not_found_route'),
            $e instanceof ModelNotFoundException => trans('messages.not_found_model'),
            default => null,
        };
    }
}
