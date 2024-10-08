<?php

require_once __DIR__ . "/../../../core/Controller.php";

class HomeController extends Controller
{
    public function get(): void
    {
        $this->loadView(view: "index");
    }

    public function getOrganizations(): void
    {
        $data = ["title" => "организации"];
        $this->loadView(view: "organizations", data: $data);
    }
}
