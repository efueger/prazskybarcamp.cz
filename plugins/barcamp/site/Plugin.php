<?php namespace Barcamp\Site;

use Backend;
use Event;
use File;
use RainLab\User\Controllers\Users;
use RainLab\User\Models\User;
use System\Classes\PluginBase;
use Yaml;

/**
 * Barcamp.Site Plugin Information File.
 */
class Plugin extends PluginBase
{
    /** @var array Plugin dependencies. */
    public $require = [
        'RainLab.User',
    ];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Barcamp Site',
            'description' => 'Site plugin for overriding and seeding other plugins.',
            'author'      => 'Vojta Svoboda',
            'icon'        => 'icon-beer',
        ];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Barcamp\Site\Components\RegistrationForm' => 'registrationForm',
        ];
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        $this->extendUserModel();
        $this->extendUsersController();
        $this->extendUsersListing();
    }

    /**
     * Extend RainLab.User model with new fields.
     */
    private function extendUserModel()
    {
        User::extend(function ($model)
        {
            // add new fillable fields
            $model->addFillable([
                'phone', 'link_facebook', 'link_twitter', 'link_instagram', 'link_linkedin', 'link_web', 'self_promo',
            ]);

            // add new model validation rules
            $model->rules['phone'] = 'required|min:9|max:14';
            $model->rules['link_facebook'] = 'url';
            $model->rules['link_twitter'] = 'url';
            $model->rules['link_instagram'] = 'url';
            $model->rules['link_linkedin'] = 'url';
            $model->rules['link_web'] = 'url';
            $model->rules['self_promo'] = 'max:1000';
        });
    }

    /**
     * Extend RainLab.User Users controller with new fields.
     */
    private function extendUsersController()
    {
        Users::extendFormFields(function ($form, $model)
        {
            // apply only for User model
            if (!$model instanceof User) {
                return;
            }

            // remove name, surname and insert it again updated
            $form->removeField('name');
            $form->removeField('surname');

            // add new fields
            $configFile = __DIR__ . '/config/users_fields.yaml';
            $config = Yaml::parse(File::get($configFile));
            $form->addFields($config);

            // add new tab fields
            $configFile = __DIR__ . '/config/users_tab_fields.yaml';
            $config = Yaml::parse(File::get($configFile));
            $form->addTabFields($config);
        });
    }

    /**
     * Extend RainLab.User Users listing.
     */
    private function extendUsersListing()
    {
        Event::listen('backend.list.extendColumns', function ($widget)
        {
            // only for Users controller
            if (!$widget->getController() instanceof Users) {
                return;
            }

            // only for User model
            if (!$widget->model instanceof User) {
                return;
            }

            // add new column
            $widget->addColumns([
                'phone' => [
                    'label' => 'barcamp.site::lang.user.phone',
                    'sortable' => true,
                    'searchable' => true,
                ],
            ]);
        });
    }
}
