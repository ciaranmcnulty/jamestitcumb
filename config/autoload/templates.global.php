<?php
declare(strict_types=1);

return [
    'dependencies' => [
        'factories' => [
            Zend\Expressive\Template\TemplateRendererInterface::class =>
                Zend\Expressive\ZendView\ZendViewRendererFactory::class,
            Zend\View\HelperPluginManager::class =>
                Zend\Expressive\ZendView\HelperPluginManagerFactory::class,
        ],
    ],

    'templates' => [
        'layout' => 'layout/default',
        'map' => [
            'layout/default' => 'templates/layout/default.phtml',
            'error/error'   => 'templates/error/error.phtml',
            'error/404'      => 'templates/error/404.phtml',
        ],
        'paths' => [
            'app' => ['templates/app'],
            'partial' => ['templates/partial'],
            'layout' => ['templates/layout'],
            'error' => ['templates/error'],
        ],
    ],

    'view_helpers' => [
        'factories' => [
            Asgrim\View\Helper\RenderPostContent::class => Asgrim\View\Helper\RenderPostContentFactory::class,
        ],
        'invokables' => [
            Asgrim\View\Helper\RenderTalk::class => Asgrim\View\Helper\RenderTalk::class,
        ],
        'aliases' => [
            'renderTalk' => Asgrim\View\Helper\RenderTalk::class,
            'renderPostContent' => Asgrim\View\Helper\RenderPostContent::class,
        ],
    ],
];
