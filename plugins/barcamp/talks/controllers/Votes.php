<?php namespace Barcamp\Talks\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Votes Back-end Controller.
 */
class Votes extends Controller
{
    public $implement = [
        'Backend.Behaviors.ListController',
    ];

    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = [
        'barcamp.talks.votes',
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Barcamp.Talks', 'talks', 'votes');
    }
}
