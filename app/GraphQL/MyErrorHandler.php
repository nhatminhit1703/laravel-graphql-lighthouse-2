<?php

namespace App\GraphQL;

use Closure;
use GraphQL\Error\Error;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Nuwave\Lighthouse\Execution\ErrorHandler;
/**
 * Report errors through the default exception handler configured in Laravel.
 */
class MyErrorHandler implements ErrorHandler
{
    /**
     * @var \Illuminate\Contracts\Debug\ExceptionHandler
     */
    protected $exceptionHandler;

    public function __construct(ExceptionHandler $exceptionHandler)
    {
        $this->exceptionHandler = $exceptionHandler;
    }

    public function __invoke(?Error $error, Closure $next): ?array
    {
        $msg = "```". $error->getMessage()."\r\n".'```'.PHP_EOL;
        toSlack($msg,'logging_staging_id',"https://hooks.slack.com/services/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");
        // Client-safe errors are assumed to be something that a client can handle
        // or is expected to happen, e.g. wrong syntax, authentication or validation
        // if ($error->isClientSafe()) {
        //     return $next($error);
        // }

        // $previous = $error->getPrevious();
        // if (null !== $previous) {
        //     // @phpstan-ignore-next-line Laravel versions prior to 7 are limited to accepting \Exception
        //     $this->exceptionHandler->report($previous);
        // }

        return $next($error);
    }
}