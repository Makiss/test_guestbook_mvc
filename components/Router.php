<?php
namespace components;

use components\Config as Config;

class Router
{
    private $routes;

    public function __construct()
    {
        $this->routes = Config::getRoutes();
    }

    // return query string
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        // Receive query string
        $uri = $this->getURI();
        $uri = substr($uri, 13);

        // Check availability of such a request in routes.php
        foreach ($this->routes as $uriPattern => $path) {

            // Compare $uriPattern and $uri
            if (preg_match("~$uriPattern~", $uri)) {

                // Receive internal path from external according to the rule
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                // Determine which controller
                // and action handle request
                $segments = explode('/', $internalRoute);

                $controllerName = array_shift($segments).'Controller';

                $controllerName = ucfirst($controllerName);

                $actionName = 'action'.ucfirst(array_shift($segments));

                $parameters = $segments;

                // Connect the file of class-controller
                $controllerFile = ROOT . '\\controllers\\' .
                                $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }

                // Create object, invoke a method (i.e. action)
                $controllerObject = new $controllerName;

                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

                if ($result != null) {
                    break;
                }
            }
        }
    }
}
