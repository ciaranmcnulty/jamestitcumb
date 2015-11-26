<?php

namespace Asgrim\Action;

use Interop\Container\ContainerInterface;
use Asgrim\Service\PostService;
use Zend\Expressive\Template\TemplateRendererInterface as TemplateRenderer;

class PostsActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new PostsAction(
            $container->get(PostService::class),
            $container->get(TemplateRenderer::class)
        );
    }
}
