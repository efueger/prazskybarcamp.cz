<?php namespace Barcamp\Site\Components;

use Barcamp\Talks\Models\Category;
use Cms\Classes\ComponentBase;

class RegistrationForm extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Registration Form',
            'description' => 'Barcamp registration form',
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $this->page['categories'] = Category::isEnabled()->orderBy('sort_order')->get();
    }
}
