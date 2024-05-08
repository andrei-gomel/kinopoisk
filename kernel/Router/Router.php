<?php

namespace App\Kernel\Router;

use App\Kernel\Auth\AuthInterface;
use App\Kernel\Database\DatabaseInterface;
use App\Kernel\Http\Redirect;
use App\Kernel\Http\RedirectInterface;
use App\Kernel\View\View;

use App\Kernel\Http\Request;
use App\Kernel\Http\RequestInterface;
use App\Kernel\Session\Session;
use App\Kernel\Session\SessionInterface;
use App\Kernel\View\ViewInterface;
use App\Kernel\Middleware\AbstractMiddleware;
use App\Kernel\Storage\StorageInterface;

class Router implements RouterInterface
{
    private array $routes = [
        'GET'  => [],
        'POST' => [],
    ];
    
    public function __construct(
        private ViewInterface $view,
        private RequestInterface $request,
        private RedirectInterface $redirect,
        private SessionInterface $session,
        private DatabaseInterface $database,
        private AuthInterface $auth,
        private StorageInterface $storage
        )
    {
        $this->initRoutes();
    }
    
    public function dispatch(string $uri, string $method): void
    {
        $route = $this->findRoute($uri, $method);

        if(!$route)
            $this->notFound();

        if($route->hasMiddlewares())
        {
            foreach($route->getMiddlewares() as $middleware)
            {
                /**
                 * @var AbstractMiddleware $middleware
                 */
                $middleware = new $middleware($this->request, $this->auth, $this->redirect);

                $middleware->handle();
            }
        }
        
        if(is_array($route->getAction()))
        {            
            [$controller, $action] = $route->getAction();

            
            /** @var Controller $controller */
            $controller = new $controller();

            //$controller->$action();

            call_user_func([$controller, 'setView'], $this->view);

            call_user_func([$controller, 'setRequest'], $this->request);

            call_user_func([$controller, 'setRedirect'], $this->redirect);

            call_user_func([$controller, 'setSession'], $this->session);

            call_user_func([$controller, 'setDatabase'], $this->database);

            call_user_func([$controller, 'setAuth'], $this->auth);

            call_user_func([$controller, 'setStorage'], $this->storage);
            
            call_user_func([$controller, $action]);
        }
        else
        {
            call_user_func($route->getAction());
        }
    }

    private function notFound()
    {
        echo '<h1>404 | Not found</h1>';
        exit;
    }
    
    private function findRoute(string $uri, string $method): Route|false
    {
        if(!isset($this->routes[$method][$uri]))
            return false;
        
        return $this->routes[$method][$uri];
    }

    private function initRoutes(): void
    {
        $routes = $this->getRoutes();

        foreach($routes as $route)
        {
            $this->routes[$route->getMethod()][$route->getUri()] = $route;
        }

        //dd($routes, $this->routes);
    }

    private function getRoutes(): array
    {
        return require_once APP_PATH . '/config/routes.php';
    }
}