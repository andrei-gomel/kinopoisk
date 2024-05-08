<?php

namespace App\Controllers;

use App\Kernel\Controller\BaseController;

class RegisterController extends BaseController
{
    public function index(): void
    {
        $this->view('register');
    }

    public function register()
    {
        //dd($this->request());
        
        $validation = $this->request()->validate([               
            'name'     => ['required', 'min:3', 'max:25'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'min:8', 'max:25', 'confirmed'],
            'password_confirmation' => ['required', 'min:8', 'max:25'],
        ]);

        if(!$validation)
        {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            $this->redirect('/register');
        }

        $userId = $this->db()->insert('users', [
            'name'    => $this->request()->input('name'),
            'email'    => $this->request()->input('email'),
            'password' => password_hash($this->request()->input('password'), PASSWORD_DEFAULT),
        ]);
    
        //dd('Пользователь успешно зарегистрирован с id: ' . $userId);

        $this->redirect('/');
    }
}