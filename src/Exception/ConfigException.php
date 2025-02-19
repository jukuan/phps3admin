<?php

declare(strict_types=1);

namespace Jukuan\PhpS3Admin\Exception;

class ConfigException extends \RuntimeException
{
    use TCreatable;

    public function __construct(
        string     $message = '',
        int        $code = 0,
        \Throwable $previous = null,
        string     $file = '',
        int        $line = 0,
        array      $context = []
    )
    {
        $message = $message ?: 'Invalid s3 config in requested array';
        parent::__construct($message, $code, $previous, $file, $line, $context);
    }
}
