<?php

namespace App\Exceptions;

use App\Exceptions\Common\CompanyNotFound;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{

    private $sentryID;

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
        CompanyNotFound::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if (app()->bound('sentry') && $this->shouldReport($exception))
        {
            $this->sentryID = app('sentry')->captureException($exception);
        }
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        // If it's an authenticationException, then use parent::render process
        // that will call the unauthenticated method
/*        if ( ! $exception instanceof AuthenticationException)
        {

            // WHOOPS module only if debug enable and not an authentification exception
            if (config('app.debug'))
            {
                return $this->renderExceptionWithWhoops($exception);
            }


            $error_display = $this->_displayError($exception);

            if ($error_display)
                return $error_display;

        }*/

        if ($this->isHttpException($exception)) {
            return $this->renderHttpException($exception);
        } else {
            return parent::render($request, $exception);
        }
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson())
        {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('auth.login'));
    }

    /**
     * Render an exception using Whoops.
     *
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    protected function renderExceptionWithWhoops(Exception $e)
    {
        $whoops = new \Whoops\Run();
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());

        return new \Illuminate\Http\Response(
            $whoops->handleException($e),
            $this->getStatus($e),
            $this->getHeaders($e)
        );
    }

    protected function returnView($view_path, $exception, $status = 404)
    {
        $datas = compact('exception', 'status');
        $datas['sentryID'] = $this->sentryID;

        $view = view($view_path, $datas)->render();

        return new Response($view, $status);
    }

    private function _displayError(Exception $e)
    {
        $status = $this->getStatus($e);

        // Defin the views folder
        view()->replaceNamespace('errors', [
            resource_path('views/errors'),
            __DIR__ . '/views',
        ]);

        if ( ! auth()->check())
        {
            $return = $this->returnView("errors::unauthenticated", $e, $status);

        } elseif (view()->exists("errors::{$status}"))
        {
            $return = $this->returnView("errors::{$status}", $e, $status);
        } elseif (view()->exists("errors::base"))
        {
            $return = $this->returnView("errors::base", $e, $status);
        } else
        {
            $return = $this->convertExceptionToResponse($e);
        }

        return $return;
    }

    protected function getStatus($e)
    {
        $status = 500;
        if (method_exists($e, 'getStatusCode'))
        {
            $status = $e->getStatusCode();
        } elseif ($e instanceof ModelNotFoundException)
        {
            $status = 404;
        }

        return $status;
    }

    public function getHeaders($e)
    {
        $header = [];
        if (method_exists($e, 'getHeaders'))
        {
            $header = $e->getHeaders();
        }

        return $header;
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\ValidationException  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json($exception->errors(), $exception->status);
    }

}
