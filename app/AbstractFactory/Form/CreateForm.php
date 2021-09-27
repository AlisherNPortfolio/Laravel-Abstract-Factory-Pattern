<?php

namespace App\AbstractFactory\Form;

use App\AbstractFactory\Form\Contracts\ICreateFormFactory;

class CreateForm
{
    private static $instance;

    protected $createFormFactory;

    private function __construct(ICreateFormFactory $createFormFactory)
    {
        $this->createFormFactory = $createFormFactory;
    }

    public static function getInstance(ICreateFormFactory $createFormFactory)
    {
        if (empty(self::$instance)) {
            self::$instance = new CreateForm($createFormFactory);
        }

        return self::$instance;
    }

    public function getTitle()
    {
        return $this->createFormFactory->getTitle();
    }

    public function getBodyElements()
    {
        return $this->createFormFactory->getBodyElements();
    }

    public function getSubmitAction()
    {
        return $this->createFormFactory->getSubmitAction();
    }
}
