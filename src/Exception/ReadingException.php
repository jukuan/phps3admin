<?php

declare(strict_types=1);

namespace Jukuan\PhpS3Admin\Exception;

class ReadingException extends \RuntimeException
{
    use TCreatable;

    public function __construct(
        string     $message = '',
        int        $code = 0,
        ?\Throwable $previous = null,
    )
    {
        $message = $message ?: 'Could not read from S3 storage';
        parent::__construct($message, $code, $previous);
    }
}
