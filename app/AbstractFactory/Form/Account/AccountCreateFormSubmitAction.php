<?php

namespace App\AbstractFactory\Form\Account;

use App\AbstractFactory\Form\Contracts\ICreateSubmitAction;

class AccountCreateFormSubmitAction implements ICreateSubmitAction
{
    protected $actionUrl;

    public function __construct()
    {
        $this->actionUrl = '/create-account';
    }

    public function getActionUrl()
    {
        return $this->actionUrl;
    }
}
