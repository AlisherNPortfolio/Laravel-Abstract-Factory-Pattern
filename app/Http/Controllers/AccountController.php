<?php

namespace App\Http\Controllers;

use App\AbstractFactory\Form\Account\AccountCreateFormFactory;
use App\AbstractFactory\Form\CreateForm;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function create()
    {
        $createForm = CreateForm::getInstance(new AccountCreateFormFactory());
        return view('pages.create', ['form' => $createForm]);
    }
}
