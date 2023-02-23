<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Exception;

use Exception;
use Throwable;

class InfrastructureException extends Exception
{
    protected final function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function create(string $message = '', int $code = 0, ?Throwable $previous = null): static
    {
        return new static($message, $code, $previous);
    }
}
