<?php namespace Barcamp\Talks\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Talks Back-end Controller.
 */
class Talks extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
    ];

    public $formConfig = 'config_form.yaml';

    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = [
        'barcamp.talks.talks',
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Barcamp.Talks', 'talks', 'talks');
    }
}
