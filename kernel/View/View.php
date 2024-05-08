<?php

namespace App\Kernel\View;

use App\Kernel\Auth\AuthInterface;
use App\Kernel\Exceptions\ViewNotFoundException;
use App\Kernel\Session\Session;
use App\Kernel\Session\SessionInterface;

class View implements ViewInterface
{
    public function __construct(
        private SessionInterface $session,
        private AuthInterface $auth
    )
    {
        
    }
    
    public function page(string $page, array $data = []): void
    {       
        $viewPath = APP_PATH . "/views/pages/$page.php";

        if(!file_exists($viewPath))
        {           
            dd("View $page not found");
            //throw new ViewNotFoundException("View $page not found");
        }

        extract(array_merge($this->defaultData(), $data));

        include_once $viewPath;
    }

    public function component(string $page): void
    {
        $componentPath = APP_PATH . "/views/components/$page.php";

        if (!$componentPath)
        {
            echo "View $page not found";
            return;
        }

        extract($this->defaultData());
        
        include_once $componentPath;
    }

    public function defaultData(): array
    {
        return [
            'view'    => $this,
            'session' => $this->session,
            'auth'    => $this->auth,
        ];
    }
}