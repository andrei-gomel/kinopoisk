<?php

namespace App\Controllers;

use App\Kernel\Controller\BaseController;
use App\Kernel\Http\Redirect;
use App\Kernel\Validator\Validator;
use App\Kernel\View\View;
use App\Services\CategoryService;
use App\Services\VideoService;

class VideoController extends BaseController
{
    private VideoService $service;
    
    public function index(): void
    {
        $this->view('videos');
    }

    public function create(): void
    {
        $categories = new CategoryService($this->db());

        
        $this->view('admin/videos/add', [
            'categories' => $categories->all(),
        ]);
    }

    public function add(): void
    {
        $this->view('admin/videos/add');
    }

    public function store(): void
    {
        $file = $this->request()->file('image');

        //dd($this->storage()->url($filePath));
        
        $validation = $this->request()->validate([
            'name' => ['required', 'min:5', 'max:100'],
            'description' => ['required', 'min:5', 'max:255'],
            'category' => ['required',]
        ]);

        if(!$validation)
        {
            foreach($this->request()->errors() as $field => $errors)
            {
                $this->session()->set($field, $errors);
            }
                        
            $this->redirect('/admin/videos/add');
        }

        $this->service()->store(
            $this->request()->input('name'),
            $this->request()->input('description'),
            $this->request()->file('image'),
            $this->request()->input('category'),
        );
        
        //dd('Видео успешно добавлено с id: ' . $id);

        $this->redirect('/admin');
    }

    public function edit()
    {
        $categories = new CategoryService($this->db());
        
        $this->view('admin/videos/update', [
            'movie' => $this->service()->find($this->request()->input('id')),
            'categories' => $categories->all(),
        ]);
    }

    public function update()
    {
        $validation = $this->request()->validate([
            'name' => ['required', 'min:5', 'max:100'],
            'description' => ['required', 'min:5', 'max:255'],
            'category' => ['required',]
        ]);

        if (!$validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            $this->redirect("/admin/videos/update?id={$this->request()->input('id')}");
        }

        $this->service()->update(
            $this->request()->input('id'),
            $this->request()->input('name'),
            $this->request()->input('description'),
            $this->request()->file('image'),
            $this->request()->input('category'),
        );

        $this->redirect('/admin');
    }

    public function destroy()
    {
        $this->service()->destroy($this->request()->input('id'));

        $this->redirect('/admin');
    }

    private function service(): VideoService
    {
        if (!isset($this->service))
            $this->service = new VideoService($this->db());

        return $this->service;
    }
}
