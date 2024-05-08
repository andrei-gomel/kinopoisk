<?php

namespace App\Controllers;

use App\Kernel\Controller\BaseController;

class CategoryController extends BaseController
{
    public function create(): void
    {
        $this->view('admin/categories/add');
    }

    public function store()
    {
        $validation = $this->request()->validate([
            'name' => ['required', 'min:3', 'max:255'],
        ]);

        if(!$validation)
        {
            foreach($this->request()->errors() as $field => $errors)
            {
                $this->session()->set($field, $errors);
            }

            $this->redirect('/admin/categories/add');
        }

        $this->db()->insert('categories', [
            'name' => $this->request()->input('name')
        ]);

        $this->redirect('/admin');
    }

    public function destroy(): void
    {
        //dd('destroy category');

        $this->db()->delete('categories', [
            'id' => $this->request()->input('id'),
        ]);

        $this->redirect('/admin');
    }
}