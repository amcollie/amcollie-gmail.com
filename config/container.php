<?php

declare(strict_types = 1);


use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Smarty\Smarty;

return [
    'settings' => fn () => require __DIR__ .'/settings.php',
    App::Class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);
        return AppFactory::create();
    },
    Smarty::class => function (ContainerInterface $container) {
        $settings = $container->get('settings')['smarty'];

        Smarty::$_CHARSET = $settings['charset'];
        $smarty = new Smarty();
        $smarty->setTemplateDir($settings['template']);
        $smarty->setCompileDir($settings['template_compile']);
        $smarty->setCacheDir($settings['template_cache']);
        return $smarty;
    },
];