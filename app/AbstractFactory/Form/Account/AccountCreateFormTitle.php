<?php

namespace App\AbstractFactory\Form\Account;

use App\AbstractFactory\Form\Contracts\ICreateFormTitle;

class AccountCreateFormTitle implements ICreateFormTitle
{
    protected $title;

    public function __construct()
    {
        $this->title = 'Account yaratish oynasi';
    }

    public function getTitle()
    {
        return $this->title;
    }
}
