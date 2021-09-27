<?php

namespace App\Http\Controllers;

use App\AbstractFactory\Form\CreateForm;
use App\AbstractFactory\Form\Store\StoreCreateFormFactory;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function create()
    {
        $createForm = CreateForm::getInstance(new StoreCreateFormFactory());
        return view('pages.create', ['form' => $createForm]);
    }
}
