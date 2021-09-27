<?php

namespace App\AbstractFactory\Form\Store;

use App\AbstractFactory\Form\Contracts\ICreateSubmitAction;

class StoreCreateFormSubmitAction implements ICreateSubmitAction
{
    protected $actionUrl;

    public function __construct()
    {
        $this->actionUrl = '/create-store';
    }

    public function getActionUrl()
    {
        return $this->actionUrl;
    }
}
