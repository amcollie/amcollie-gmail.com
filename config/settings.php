<?php

declare(strict_types = 1);

error_reporting(E_ALL);
ini_set("display_errors", 1);

return [
    'smarty' => [
        'template' => dirname(__DIR__) . '/views',
        'template_compile' => dirname(__DIR__). '/tmp/templates_compile',
        'template_cache' => dirname(__DIR__). '/tmp/cache',
        'charset' => 'UTF-8',
        'global' => []
    ]
];