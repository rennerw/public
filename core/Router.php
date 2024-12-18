<?php

namespace App\Core;

class Router{

    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response){

        $this->request = $request;
        $this->response = $response;

    }

    public function get($path, $callback){

        $this->routes["get"][$path] = $callback;

    }

    public function post($path, $callback){

        $this->routes["post"][$path] = $callback;

    }

    public function resolve(){

        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        
        if ($callback === false){
            $this->response->setStatusCode(404);
            return "Not found";
            exit;
        }
        if(is_string($callback)){
            return $this->renderView($callback);
        }
        return call_user_func($callback);
        exit;
    }

    public function renderView($view){

        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view);
        return str_replace("{{content}}", $viewContent, $layoutContent);

    }

    protected function layoutContent(){

        ob_start();
        include_once Application::$ROOT_DIR."/Views/layouts/main.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view){
        ob_start();
        include_once Application::$ROOT_DIR."/Views/$view.php";
        return ob_get_clean();
    }

}