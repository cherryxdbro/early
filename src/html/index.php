<?php

require_once __DIR__ . "/core/Router.php";

$router = new Router();
$router->dispatch(uri: $_SERVER["REQUEST_URI"]);