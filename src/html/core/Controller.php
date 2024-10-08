<?php

class Controller
{
    protected function loadView(string $view, array $data = []): void
    {
        extract(array: $data);
        $controller = strtolower(string: str_replace(search: "Controller", replace: "", subject: get_class(object: $this)));
        $viewFile = __DIR__ . "/../areas/early/views/$controller/$view.php";
        if (file_exists(filename: $viewFile)) {
            ob_start();

            require_once $viewFile;

            $content = ob_get_clean();

            require_once __DIR__ . "/../areas/early/views/shared/index.php";

        } else {
            echo "Представление $view не найдено в контроллере $controller";
        }
    }
}
