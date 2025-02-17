<?php

namespace App\Modules\Factories;

use App\Modules\Entities\Error;
use Illuminate\Support\Arr;

class ErrorFactory
{
    protected static $instance;

    protected static $errors = [];
    protected static $warnings = [];
    protected static $httpStatusCode = 200;

    /**
     * Protected constructor to prevent creating a new instance of the
     * singleton via the `new` operator.
     */
    protected function __construct()
    {
        // your constructor logic here.
    }

    static function addWarning(string $warningMessage)
    {
        static::$warnings[] = $warningMessage;
    }

    /**
     * Initialise an error object by code
     *
     * @param integer $errorCode
     * @return \App\Modules\Entities\Error
     */
    static function initErrorByCode(int $errorCode): Error
    {
        return new Error($errorCode);
    }

    static function addError(int $code, string $message = ''): void
    {
        $errorDefinition = self::initErrorByCode($code);
        $httpStatusCode = $errorDefinition->getHttpStatusCode();

        if (!empty($httpStatusCode)) {
            static::$httpStatusCode = $httpStatusCode;
        }

        $errorMessage = $errorDefinition->getErrorMessage();
        if (!empty($message)) {
            $errorMessage = $message;
        }

        static::$errors[] = ['code' => $code, 'message' => $errorMessage];
    }

    static function addErrors(array $messages)
    {
        foreach ($messages as $message) {
            self::addError(0, $message);
        }
    }

    /**
     * Check if error repository contain an specific application error code
     *
     * @param integer $code
     * @return boolean
     */
    static function containsApplicationErrorCode(int $code): bool
    {
        foreach (static::$errors as $error) {
            if ($error['code'] === $code) {
                return true;
            }
        }

        return false;
    }


    static function getWarnings(): array
    {
        return static::$warnings;
    }

    static function getErrors(): array
    {
        return static::$errors;
    }

    static function getErrorMessages(): array
    {
        if (!self::hasError()) {
            return [];
        }

        return Arr::pluck(static::$errors, 'message');
    }

    static function getHttpStatusCode(): int
    {
        return static::$httpStatusCode ?? 200;
    }

    static function hasError(): bool
    {
        return count(static::$errors) > 0;
    }



    static function purgeErrors()
    {
        static::$errors = [];
    }

    static function resetHttpStatusCode()
    {
        static::$httpStatusCode = 200;
    }
}