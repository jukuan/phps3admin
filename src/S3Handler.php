<?php

declare(strict_types=1);

namespace Jukuan\PhpS3Admin;

use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use Jukuan\PhpS3Admin\Exception\ReadingException;

readonly class S3Handler
{
    public function __construct(
        private S3Client $s3Client
    ) {
    }

    public function __call(string $name, array $arguments): mixed
    {
        try {
            return $this->s3Client->$name(...$arguments);
        } catch (AwsException $e) {
        }

        return null;
    }

    public function buckets(): array
    {
        try {
            $result = $this->s3Client->listBuckets();

            return $result['Buckets'] ?? [];
        } catch (AwsException $e) {
            throw ReadingException::build($e);
        }
    }

    public function objects(string $bucket, string $prefix = ''): array
    {
        try {
            $result = $this->s3Client->listObjects([
                'Bucket' => $bucket,
                'Prefix' => $prefix,
            ]);

            return $result['Contents'] ?? [];
        } catch (AwsException) {
            return [];
        }
    }

    public function directories(string $bucket, string $prefix = ''): array
    {
        try {
            $result = $this->s3Client->listObjects([
                'Bucket' => $bucket,
                'Prefix' => $prefix,
                'Delimiter' => '/'
            ]);

            return $result['CommonPrefixes'] ?? [];
        } catch (AwsException) {
            return [];
        }
    }

    public function key(string $bucket, string $key): array
    {
        try {
            $result = $this->s3Client->getObjectAcl([
                'Bucket' => $bucket,
                'Key' => $key,
            ]);

            return $result->toArray();
        } catch (AwsException $e) {
            throw ReadingException::build($e);
        }
    }

    public function delete(string $bucket, string $key): array
    {
        try {
            $result = $this->s3Client->deleteObject([
                'Bucket' => $bucket,
                'Key' => $key,
            ]);

            return $result->toArray();
        } catch (AwsException $e) {
            throw ReadingException::build($e);
        }
    }
}