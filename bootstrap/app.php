<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Modules\Entities\Error;
use App\Modules\Entities\Response;
use App\Modules\Factories\ErrorFactory;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Laravel\Passport\Exceptions\MissingScopeException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\Access\AuthorizationException;
use GuzzleHttp\Exception\ServerException;
use App\Http\Middleware\IsAgent2FAVerified;
use App\Modules\Commands\UploadSOACSFromUPToMinio;
use App\Modules\Common\Factories\EnvFactory;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                $messageBag = $e->errors();


                if (!empty($messageBag)) {
                    foreach ($messageBag as $key => $value) {
                        foreach ($value as $message) {
                            ErrorFactory::addError(Error::VALIDATION_FAILED, $message);
                        }
                    }
                } else {
                    # WIP check if $e->getMessage() can array
                    ErrorFactory::addError(Error::VALIDATION_FAILED, $e->getMessage());
                }

                return (new Response)->error();
            }
        });

        $exceptions->renderable(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                ErrorFactory::addError(Error::UNAUTHORIZED);
                return (new Response)->error();
            }
        });

        $exceptions->renderable(function (UnauthorizedException $e, Request $request) {
            if ($request->is('api/*')) {
                ErrorFactory::addError(Error::UNAUTHORIZED);
                return (new Response)->error();
            }
        });

        $exceptions->renderable(function (OAuthServerException $e, Request $request) {
            if ($request->is('api/*')) {
                ErrorFactory::addError(Error::UNAUTHORIZED);
                return (new Response)->error();
            }
        });

        $exceptions->renderable(function (MissingScopeException $e, Request $request) {
            if ($request->is('api/*')) {
                ErrorFactory::addError(Error::INVALID_ARGUMENTS);
                return (new Response)->error();
            }
        });

        $exceptions->renderable(function (NotFoundHttpException $e, Request $request) {

            if ($request->is('api/*')) {
                ErrorFactory::addError(Error::HTTPNOTFOUND);
                return (new Response)->error();
            }
        });

        $exceptions->renderable(function (Throwable $e, Request $request) {

            if ($request->is('api/*')) {
                ErrorFactory::addError(Error::EXCEPTION, $e->getMessage() ?? "Exception error Occured");
                return (new Response)->error();
            }
        });

        $exceptions->renderable(function (ServerException $e, Request $request) {

            if ($request->is('api/*')) {
                ErrorFactory::addError(Error::EXCEPTION, $e->getMessage() ?? "ServerException error Occured");
                return (new Response)->error();
            }
        });

        $exceptions->renderable(function (QueryException $e, Request $request) {
            if ($request->is('api/*')) {
                ErrorFactory::addError(Error::EXCEPTION, $e->getMessage() ?? "QueryException error Occured");
                return (new Response)->error();
            }
        });
    })
    ->create();
