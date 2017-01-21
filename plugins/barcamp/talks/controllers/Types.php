<?php namespace Barcamp\Talks\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Categories Back-end Controller.
 */
class Types extends Controller
{
    public $implement = [
        'Backend\Behaviors\FormController',
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\ReorderController',
    ];

    public $formConfig = 'config_form.yaml';

    public $listConfig = 'config_list.yaml';

    public $reorderConfig = 'config_reorder.yaml';

    public $requiredPermissions = [
        'barcamp.talks.types',
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Barcamp.Talks', 'talks', 'types');
    }
}
