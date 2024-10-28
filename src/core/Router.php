<?php

namespace Kernel;


class Router
{
    protected Request $request;
    protected Response $response;
    protected array $routes = [];
    protected array $params = [];

    public function __construct(Request $request, Response $response){
        $this->request = $request;
        $this->response = $response;
    }

    public function add(string $path, callable|array $callback, array|string $method): self
    {
        $path = trim($path, '/');
        if(is_array($method)){
            $method = array_map('strtoupper', $method);
        }else{
            $method = [strtoupper($method)];
        }
        $this->routes[]=
            [
                'path' => "/$path",
                'callback' => $callback,
                'middleware' => null,
                'method' => $method
            ];
        return $this;
    }

    public function get(string $path, callable|array $callback):self
    {
        return $this->add($path, $callback, 'GET');
    }
    public function post(string $path, callable|array $callback):self
    {
        return $this->add($path, $callback, 'POST');
    }

    public function dispatch():mixed
    {
        $path = $this->request->getPath();
        $route = $this->matchRoute($path);
        if($route === false){
            $this->response->setResponseCode(404);
            echo "Page not found";
            die();
        }
        dump($route);
        if (is_array($route['callback'])){
            $route['callback'][0] = new $route['callback'][0];
        }
        return call_user_func($route['callback']);
    }
    public function getRoutes():array
    {
        return $this->routes;
    }

    public function getParams(){
        return $this->params;
    }

    protected function matchRoute(string $path):mixed
    {
        foreach ($this->routes as $route) {
            if((preg_match("#^{$route['path']}$#", "/{$path}", $matches))
                &&
                in_array($this->request->getMethod(), $route['method']))
            {
                foreach ($matches as $k=>$value){
                    if (is_string($k)){
                        $this->params[$k] = $value;
                    }
                }
                return $route;
            }

        }
        return false;
    }
}