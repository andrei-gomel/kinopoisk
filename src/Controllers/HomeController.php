<?php

namespace App\Controllers;

use App\Kernel\Controller\BaseController;
use App\Kernel\View\View;

class HomeController extends BaseController
{
    public function index(): void
    {
        $this->view('home');
    }
}