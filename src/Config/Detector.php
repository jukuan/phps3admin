<?php

declare(strict_types=1);

namespace Jukuan\PhpS3Admin\Config;

class Detector
{
    public function __construct()
    {
    }

    public function detect(): ?string
    {
        $directories = [
            getcwd() . '/config.ini',
            getcwd() . '/../config.ini',
            getenv('HOME') . '/.s3cfg',
            '/var/www/html/.s3cfg',
        ];

        foreach ($directories as $directory) {
            if (file_exists($directory)) {
                return $directory;
            }
        }

        return null;
    }
}