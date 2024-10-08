<?php

class Router
{
    public function dispatch(string $uri): void
    {
        $parts = explode(separator: "/", string: trim(string: $uri, characters: "/"));
        $area = empty($parts[0]) ? "early" : $parts[0];
        $controller = ucfirst(string: empty($parts[1]) ? "home" : $parts[1]) . "Controller";
        $action = empty($parts[2]) ? "" : $parts[2];
        $controllerFile = __DIR__ . "/../areas/$area/controllers/$controller.php";
        if (!file_exists(filename: $controllerFile)) {
            $this->error(message: "Контроллер $controller не найден в области $area");
            return;
        }
        require_once $controllerFile;
        if (!class_exists(class: $controller)) {
            $this->error(message: "Класс контроллера $controller не найден");
            return;
        }
        $controllerObject = new $controller();
        $httpMethod = $_SERVER["REQUEST_METHOD"];
        $method = strtolower(string: $httpMethod) . ucfirst(string: $action);
        if (!method_exists(object_or_class: $controllerObject, method: $method)) {
            $this->error(message: "Метод $method не найден в контроллере $controller");
            return;
        }
        $controllerObject->$method();
    }

    private function error(string $message): void
    {
        http_response_code(response_code: 404);
        echo $message;
    }
}
