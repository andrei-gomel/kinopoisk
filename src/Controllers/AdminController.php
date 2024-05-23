<?php

namespace App\Controllers;

use App\Kernel\Controller\BaseController;
use App\Services\CategoryService;
use App\Services\VideoService;

class AdminController extends BaseController
{
    public function index()
    {
        $categories = new CategoryService($this->db());

        $movies = new VideoService($this->db());

        $this->view('admin/index', [
            'categories' => $categories->all(),
            'movies'     => $movies->all(),
        ]);
    }
}