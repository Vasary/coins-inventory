<?php

declare(strict_types=1);

use DG\BypassFinals;
use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload_runtime.php';

new Dotenv()->bootEnv(dirname(__DIR__) . '/.env');

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}

BypassFinals::denyPaths(
    [
        '*/vendor/phpunit/*',
    ]
);
BypassFinals::enable();
