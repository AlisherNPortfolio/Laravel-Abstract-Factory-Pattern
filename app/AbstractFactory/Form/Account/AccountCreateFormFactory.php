<?php

namespace App\AbstractFactory\Form\Account;

use App\AbstractFactory\Form\Contracts\ICreateFormFactory;

class AccountCreateFormFactory implements ICreateFormFactory
{
    public function getTitle()
    {
        $title = new AccountCreateFormTitle();
        return $title->getTitle();
    }

    public function getBodyElements()
    {
        $formBody = new AccountCreateFormBody();
        return $formBody->getBodyElements();
    }

    public function getSubmitAction()
    {
        $submitAction = new AccountCreateFormSubmitAction();
        return $submitAction->getActionUrl();
    }
}
