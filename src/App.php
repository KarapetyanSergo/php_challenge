<?php

namespace App;

use App\Http\Requests\Request;
use ErrorException;
use Exception;

class App
{
    public function run(): void
    {
        try {
            $router = new Router();

            $bindings = $router->getBindings();
    
            if (!$bindings) throw new ErrorException("Route does not exist");
            
            if ($bindings['middleware']) {
                $middleware = new $bindings['middleware']();
                if (!$middleware->check()) throw new ErrorException($middleware->getMessage());;
            };

            $controllerDetails = explode('@', $bindings['controller']);
    
            $controller = new $controllerDetails[0]();
            $action = $controllerDetails[1];
    
            $this->sendResponse($controller->$action(new Request($router->getBody())));
        } catch (Exception $e) {
            $this->sendResponse([
                'message' => $e->getMessage()
            ]);
        }
    }

    private function sendResponse(array $response): void
    {
        header('Content-type: json/application');

        $response = json_encode($response);

        print($response);
    }
}