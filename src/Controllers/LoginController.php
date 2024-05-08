<?php

namespace App\Controllers;

use App\Kernel\Controller\BaseController;

class LoginController extends BaseController
{
    public function index(): void
    {
        $this->view('login');
    }

    public function login()
    {
        $email = $this->request()->input('email');
        $password = $this->request()->input('password');

        //dd($this->auth()->attempt($email, $password), $_SESSION);

        if($this->auth()->attempt($email, $password))
            return $this->redirect('/');

        $this->session()->set('error', 'Неверный логин или пароль');
        
        return $this->redirect('/login');
    }

    public function logout()
    {
        $this->auth()->logout();

        return $this->redirect('/');
    }
}
