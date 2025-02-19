<?php

namespace Ui\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class UiExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('logo', [$this, 'generateSvgLogo']),
            new TwigFunction('urlWith', [$this, 'urlWith']),
            new TwigFunction('url', [$this, 'generateUrl']),
            new TwigFunction('href', [$this, 'generateHref']),
            new TwigFunction('toBucket', [$this, 'toBucket']),
            new TwigFunction('toKey', [$this, 'toKey']),
            new TwigFunction('toPrefix', [$this, 'toPrefix']),
            new TwigFunction('toUpload', [$this, 'toUpload']),
            new TwigFunction('props', [$this, 'displayProps']),
        ];
    }

    public function generateSvgLogo(int|string $width = 0): string
    {
        $width = $width ?: 32;

        return '<svg viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg" width="'.$width.'">
                <defs>
                    <linearGradient id="grad" x1="0%" y1="0%" x2="0%" y2="99%">
                        <stop offset="0%" stop-color="#039BE5" />
                        <stop offset="90%" stop-color="#1E88E5" />
                    </linearGradient>
                    <filter id="text-shadow" x="0" y="0">
                        <feDropShadow dx="1" dy="1" stdDeviation="1" flood-color="#000" />
                    </filter>
                </defs>
                <circle r="50" cx="60" cy="60" fill="url(#grad)" stroke="#303F9F" stroke-width="1" />
                <text x="50%" y="53%" dominant-baseline="middle" text-anchor="middle" font-size="56" font-family="Arial, sans-serif" fill="white" font-weight="bold" filter="url(#text-shadow)">S3</text>
            </svg>';
    }

    public function buildUrl(string $path, array $args = []): string
    {
        $path = ltrim($path, '/');
        $path = str_replace(['.php', '.html', '.twig'], '', $path);
        $path = '/'.$path .'.php';

        if (count($args) > 0) {
            $path .= '?'.http_build_query($args);
        }

        return $path;
    }

    public function generateUrl(): string
    {
        $args = func_get_args() ?: ['/'];
        $path = reset($args);
        $args = array_slice($args, 1);

        return $this->buildUrl($path, $args);
    }

    public function generateHref(string $bucket, string $key = '', string $prefix = ''): string
    {
        $path = 'bucket';
        $params = [];

        if ($bucket) {
            $params['b'] = $bucket;
        }

        if ($prefix) {
            $params['p'] = trim($prefix, '/');
        }

        if ($key) {
            $params['k'] = $key;
            $path = 'key';
        }

        return $this->buildUrl($path, $params);
    }

    public function toBucket(string $bucket): string
    {
        return $this->generateHref($bucket);
    }

    public function toKey(string $bucket, string $key): string
    {
        return $this->generateHref($bucket, $key);
    }

    public function toPrefix(string $bucket, string $prefix): string
    {
        return $this->generateHref($bucket, '', $prefix);
    }

    public function toUpload(string $bucket, string $prefix = ''): string
    {
        return $this->buildUrl('upload', [
            'b'=> $bucket,
            'p' => $prefix,
        ]);
    }

    public function urlWith(string $key, string $value): string
    {
        $url = $_SERVER['REQUEST_URI'] ?? '';
        $parsedUrl = parse_url($url);
        parse_str($parsedUrl['query'] ?? '', $queryParams);
        $queryParams[$key] = $value;
        $queryString = http_build_query($queryParams);

        return $parsedUrl['path'] . '?' . $queryString;
    }

    public function displayProps(mixed $props): string
    {
        if (is_array($props) || is_object($props)) {
            $out = '';

            foreach ($props as $key => $value) {
                $value = $this->displayProps($value);
                $out .= $key.': '.$value.'<br>';
            }

            return $out;
        }

        return (string) $props;
    }
}
