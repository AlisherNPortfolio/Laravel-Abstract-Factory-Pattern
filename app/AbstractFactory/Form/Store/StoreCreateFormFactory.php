<?php

namespace App\AbstractFactory\Form\Store;

use App\AbstractFactory\Form\Contracts\ICreateFormFactory;

class StoreCreateFormFactory implements ICreateFormFactory
{
    public function getTitle()
    {
        $title = new StoreCreateFormTitle();
        return $title->getTitle();
    }

    public function getBodyElements()
    {
        $formBody = new StoreCreateFormBody();
        return $formBody->getBodyElements();
    }

    public function getSubmitAction()
    {
        $submitAction = new StoreCreateFormSubmitAction();
        return $submitAction->getActionUrl();
    }
}
