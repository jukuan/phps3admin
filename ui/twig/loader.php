<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/extensions/UiExtension.php';

$cacheDir = __DIR__.'/../../cache/twig';
file_exists($cacheDir) || mkdir($cacheDir, 0755, true);

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ .'/templates');
$twig = new \Twig\Environment($loader, [
    'debug' => true,
    'cache' => is_writable($cacheDir) ? $cacheDir : false,
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());
$twig->addExtension(new \Ui\Twig\UiExtension());

return $twig;
