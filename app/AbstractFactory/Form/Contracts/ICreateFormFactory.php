<?php

namespace App\AbstractFactory\Form\Contracts;

interface ICreateFormFactory
{
    public function getTitle();

    public function getBodyElements();

    public function getSubmitAction();
}
