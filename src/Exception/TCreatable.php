<?php

declare(strict_types=1);

namespace Jukuan\PhpS3Admin\Exception;

trait TCreatable
{
    final public static function build(
        ?\Throwable $previous = null,
        ?string $message = null,
        int $code = 0,
    ): static
    {
        $message = $message ?: $previous->getMessage();

        return new static($message, $code, $previous);
    }

    final public static function create(
        string $message,
        int $code = 0,
        ?\Throwable $previous = null,
    ): static
    {
        return new static($message, $code, $previous);
    }
}
