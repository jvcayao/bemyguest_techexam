<?php

namespace App\Modules\Entities;

use App\Modules\Traits\MyConstants;
use Exception;

class Error
{
    use MyConstants;
    /**
     * Error Constants Start
     */
    const INVALID_ARGUMENTS = 1001;

    const EXCEPTION = 1010;

    const VALIDATION_FAILED = 1020;
    const AUTHENTICATION_FAILED = 1201;
    const ACCESS_DISABLED = 1205;
    const UNAUTHORIZED = 1211;

    const HTTPNOTFOUND = 404;

    const MAINTENANCE_MODE = 404;

    const INTERNAL_ERROR = 500;
    const TWOFA_FAILED = 1202;

    const TOO_MANY_ATTEMPTS = 429;
    const PASSWORD_RESET = 1203;
    const SESSION_TIMEOUT = 1204;


   

    private $errorCodeDefinitionFile = __DIR__ . '/../Definitions/ErrorCodes.json';

    public $code = 0;
    public $codeWord = '';
    public $message = '';
    public int $httpStatusCode = 200;

    function __construct(int $code)
    {
        $this->code = $code;

        $json = json_decode(file_get_contents($this->errorCodeDefinitionFile), true);

        $definition = array_filter($json, function ($value) use ($code) {
            return $value['code'] == $code;
        });

        if (empty($definition)) {
            throw new Exception("invalid application error code provided");
        }

        $definition = reset($definition); //first record
        $this->message = $definition['description'];
        $this->codeWord = $definition['codeWord'];
        $this->httpStatusCode = $definition['httpStatusCode'] ?? 200;
    }

    function getErrorMessage(): string
    {
        return $this->message;
    }

    function getCodeWord(): string
    {
        return $this->codeWord;
    }

    function getErrorCode(): int
    {
        return $this->code;
    }

    function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }
}
