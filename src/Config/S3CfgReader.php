<?php

declare(strict_types=1);

namespace Jukuan\PhpS3Admin\Config;

use Aws\S3\S3Client;
use Jukuan\PhpS3Admin\Exception\ConfigException;

class S3CfgReader
{
    final public function __construct(
        private readonly string $filePath
    )
    {
        if (!file_exists($filePath)) {
            throw new ConfigException('File not found: '.$filePath);
        }
    }

    public static function create(string $filePath = ''): static
    {
        if ('' === $filePath) {
            $filePath = getenv('HOME') . '/.s3cfg';
        }

        return new static($filePath);
    }

    public function parse(): array
    {
        $config = [];
        $lines = file($this->filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            if (str_starts_with($line, '#')) {
                // Skip comments
                continue;
            }

            // Handle variable references
            if (preg_match('/^\s*([^=]+)\s*=\s*(.+?)$/', $line, $matches)) {
                $key = trim($matches[1]);
                $value = trim($matches[2]);

                // Replace references
                if (preg_match('/%\((.+?)\)s/', $value, $ref_matches)) {
                    $ref_key = $ref_matches[1];
                    if (isset($config[$ref_key])) {
                        $value = str_replace("%($ref_key)s", $config[$ref_key], $value);
                    }
                }

                $config[$key] = $value;
            }
        }

        return $config;
    }

    public function buildClient(): S3Client
    {
        $config = $this->parse();

        return Builder::fromArray($config)->getS3Client();
    }
}
