<?php

namespace App\Controllers;

use App\Kernel\Controller\BaseController;
use App\Kernel\Http\Redirect;
use App\Kernel\Validator\Validator;
use App\Kernel\View\View;

class VideoController extends BaseController
{
    public function index(): void
    {
        $this->view('videos');
    }

    public function add(): void
    {
        $this->view('admin/videos/add');
    }

    public function store()
    {        
        
        //dd($this->request()->file('image'));

        $file = $this->request()->file('image');

        $filePath = $file->move('video');

        //dd($file->move('video', 'test.jpg'));

        dd($this->storage()->url($filePath));
        
        $validation = $this->request()->validate([
            'name' => ['required', 'min:3', 'max:15'],
        ]);

        if(!$validation)
        {
            foreach($this->request()->errors() as $field => $errors)
            {
                $this->session()->set($field, $errors);
            }
                        
            $this->redirect('/admin/videos/add');
            //dd('Validation failed', $this->request()->errors());
        }       
        
        $id = $this->db()->insert('videos', [
            'name' => $this->request()->input('name'),
         ]);
        
        dd('Видео успешно добавлено с id: ' . $id);
    }
}
