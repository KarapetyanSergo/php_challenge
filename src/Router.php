<?php

namespace App;

class Router
{
    private $routes;

    public function __construct()
    {
        $this->routes = include 'routes/routes.php';
    }

    public function getBindings(): array
    {
        return $this->routes[$_SERVER['REQUEST_METHOD']][$_SERVER['PATH_INFO']] ?? [];
    }

    public function getBody(): array
    {
        return $this->getQueryParams();
    }

    private function getQueryParams(): array
    {
        return $_REQUEST;
    }
}