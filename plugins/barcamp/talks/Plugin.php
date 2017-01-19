<?php namespace Barcamp\Talks;

use Backend;
use System\Classes\PluginBase;

/**
 * Barcamp.Talks Plugin Information File.
 */
class Plugin extends PluginBase
{
    /** @var array Plugin dependencies. */
    public $require = [
        'RainLab.User',
        'Barcamp.Site',
    ];

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            // 'Barcamp\Talks\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'talks' => [
                'label'       => 'Program',
                'url'         => Backend::url('barcamp/talks/talks'),
                'icon'        => 'icon-calendar',
                'permissions' => ['barcamp.talks.*'],
                'order'       => 500,
                'sideMenu' => [
                    'talks' => [
                        'label'       => 'Schválené',
                        'url'         => Backend::url('barcamp/talks/talks'),
                        'icon'        => 'icon-user-plus',
                        'permissions' => ['barcamp.talks.talks'],
                        'order'       => 100,
                    ],
                    'waiting' => [
                        'label'       => 'Čekající na schválení',
                        'url'         => Backend::url('barcamp/talks/talks'),
                        'icon'        => 'icon-user',
                        'permissions' => ['barcamp.talks.talks'],
                        'order'       => 200,
                    ],
                    'votes' => [
                        'label'       => 'Hlasování',
                        'url'         => Backend::url('barcamp/talks/talks'),
                        'icon'        => 'icon-comment-o',
                        'permissions' => ['barcamp.talks.categories'],
                        'order'       => 300,
                    ],
                ],
            ],
        ];
    }
}
