<?php

declare(strict_types = 1);

namespace App\Renderer;

use Psr\Http\Message\ResponseInterface;
use Smarty\Smarty;

final class TemplateRenderer
{
    public function __construct(private Smarty $smarty) {
    }

    public function render(ResponseInterface $response, string $template, array $data = []): ResponseInterface
    {
        $this->smarty->assign($data);

        ob_start();
        $this->smarty->display($template);
        $response->getBody()->write(
            (string)ob_get_clean()
        );

        return $response;
    }
}