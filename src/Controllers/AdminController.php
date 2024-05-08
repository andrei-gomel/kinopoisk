<?php

namespace App\Controllers;

use App\Kernel\Controller\BaseController;
use App\Services\CategoryService;

class AdminController extends BaseController
{
    public function index()
    {
        //$categories = $this->db()->get('categories');
        $categories = new CategoryService($this->db());

        $res = $categories->all();

        //dd($res);
        
        $this->view('admin/index', [
            'categories' => $res,
        ]);
    }
}