<?php

use JetBrains\PhpStorm\NoReturn;

function redirectIfNotAuthenticated(string $url): void
{
    if (!($_SESSION['authenticated'] ?? '')) {
        redirect($url);
    }
}

#[NoReturn] function redirect(string $url): void
{
    header("Location: {$url}");
    exit();
}

function dump(...$variables): void
{
    foreach ($variables as $variable) {
        echo "<pre>" . print_r($variable, true) . "</pre>";
    }
}

function view(string $path, array $data = []): void
{
    //get content
    $content = getView($path, $data);
    //get document and pass content as parameter
    echo getView(__DIR__ . '/view/app/document.php', compact('content'));
}

function getView(string $path, array $data): bool|string
{
    extract($data);
    ob_start();
    include $path;

    return ob_get_clean();
}

function getRootUrl()
{
    $config = include __DIR__ . "/config.php";

    return $config['root_uri'];
}

function publicUrl(string $url = ''): string
{
    return getRootUrl() . $url;
}

function storageUrl(string $url = ''): string
{
    if($url) {
        $url = '/storage/'.$url;
    } else {
        $url = 'storage';
    }
    return getRootUrl() . $url;
}

function imagesUrl(string $name): string
{
    $url = '';
    if($name) {
        $url = '/images/'.$name;
    } else {
        $url = '/images'. $url;
    }

    return storageUrl() . $url;
}
function renderDocument($content): bool|string
{
    return getView(__DIR__.'/Views/app/document.php', compact('content'));
}