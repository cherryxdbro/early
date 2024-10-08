<?php

require_once __DIR__ . "/../../../core/Controller.php";
require_once __DIR__ . "/../../../models/Organization.php";

class OrganizationsController extends Controller
{
    private $organizationModel;

    public function __construct()
    {
        $this->organizationModel = new Organization();
    }

    private function jsonResponse(array $data): void
    {
        header(header: "Content-Type: application/json");
        echo json_encode(value: $data);
    }

    public function get(): void
    {
        $organizations = $this->organizationModel->getAllOrganizations();
        $this->jsonResponse(data: ["result" => $organizations]);
    }

    public function post(): void
    {
        $name = $_POST["organization_name"] ?? null;
        $address = $_POST["organization_address"] ?? null;
        $phone = $_POST["organization_phone"] ?? null;
        $divisionIds = $_POST["division_ids"] ?? [];
        if ($name && $address && $phone) {
            $this->organizationModel->addOrganization(name: $name, address: $address, phone: $phone, divisionIds: $divisionIds);
            $this->jsonResponse(data: ["result" => "организация добавлена"]);
        } else {
            $this->jsonResponse(data: ["error" => "не указаны данные для добавления"]);
        }
    }

    public function patch(): void
    {
        parse_str(string: file_get_contents(filename: "php://input"), result: $fields);
        $id = $data["id"] ?? null;
        if ($id) {
            if (!empty($data)) {
                $this->organizationModel->updateOrganization(id: $id, fields: $data);
                $this->jsonResponse(data: ["result" => "организация обновлена"]);
            } else {
                $this->jsonResponse(data: ["error" => "не указаны данные для обновления"]);
            }
        } else {
            $this->jsonResponse(data: ["error" => "не указан id для обновления"]);
        }
    }

    public function delete(): void
    {
        parse_str(string: file_get_contents(filename: "php://input"), result: $data);
        $id = $data["id"] ?? null;
        if ($id) {
            $this->organizationModel->deleteOrganization(id: $id);
            $this->jsonResponse(data: ["result" => "организация удалена"]);
        } else {
            $this->jsonResponse(data: ["error" => "не указан id для удаления"]);
        }
    }
}
