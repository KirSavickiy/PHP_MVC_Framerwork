<?php

namespace Kernel;

class Request
{
    public string $uri;

    public function __construct(string $uri)
    {
        $this->uri = trim(urldecode($uri), '/');
    }
    public function getMethod(): string{
        return $_SERVER['REQUEST_METHOD'];
    }

    public function isGet(): bool
    {
        if($this->getMethod() == 'GET'){
            return true;
        }else{
            return false;
        }
    }

    public function isPost(): bool
    {
        if($this->getMethod() == 'POST'){
            return true;
        }else{
            return false;
        }
    }

    public function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    public function get($name, $default = null) :?string
    {
        return $_GET[$name] ?? $default;
    }

    public function post($name, $default = null) :?string
    {
        return $_POST[$name] ?? $default;
    }

    public function getPath():string
    {
    return $this->removeQueryString();
    }

    protected function removeQueryString():string
    {
        if ($this->uri){
            $params = explode('?', $this->uri);
            return trim($params[0], '/');
        }
    return "";
    }

}