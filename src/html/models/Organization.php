<?php

require_once __DIR__ . "/../core/Model.php";

class Organization extends Model
{
    public function addOrganization(string $name, string $address, string $phone, array $divisionIds = []): bool
    {
        $this->execute(
            sql: "INSERT INTO organizations (name, address, phone) VALUES (:name, :address, :phone)",
            params: [
                "name" => $name,
                "address" => $address,
                "phone" => $phone
            ]
        );
        $organizationId = $this->db->lastInsertId();
        if ($divisionIds) {
            $sql = "INSERT INTO organization_divisions (organization_id, division_id) VALUES (:organization_id, :division_id)";
            foreach ($divisionIds as $divisionId) {
                $this->execute(
                    sql: $sql,
                    params: [
                        "organization_id" => $organizationId,
                        "division_id" => $divisionId
                    ]
                );
            }
        }
        return true;
    }

    public function deleteOrganization(int $id): bool
    {
        return $this->execute(
            sql: "DELETE FROM organizations WHERE id = :id",
            params: ["id" => $id]
        );
    }

    public function getAllOrganizations(): array
    {
        return $this->fetchAll(sql: "SELECT * FROM organizations");
    }

    public function getDivisionsByOrganizationId(int $organizationId): array
    {
        $sql = "SELECT o.* 
                FROM organizations o
                JOIN organization_divisions od ON o.id = od.division_id
                WHERE od.organization_id = :organization_id";
        return $this->fetchAll(
            sql: $sql,
            params: ["organization_id" => $organizationId]
        );
    }

    public function getOrganizationById(int $id): mixed
    {
        return $this->fetch(
            sql: "SELECT * FROM organizations WHERE id = :id",
            params: ["id" => $id]
        );
    }

    public function updateOrganization(int $id, array $fields): bool
    {
        $setOfChanges = [];
        $params = ["id" => $id];
        if (!empty($fields["name"])) {
            $setOfChanges[] = "name = :name";
            $params["name"] = $fields["name"];
        }
        if (!empty($fields["address"])) {
            $setOfChanges[] = "address = :address";
            $params["address"] = $fields["address"];
        }
        if (!empty($fields["phone"])) {
            $setOfChanges[] = "phone = :phone";
            $params["phone"] = $fields["phone"];
        }
        if (!empty($setOfChanges)) {
            $sql = "UPDATE organizations SET " . implode(separator: ", ", array: $setOfChanges) . " WHERE id = :id";
            $this->execute(sql: $sql, params: $params);
        }
        if (!empty($fields["divisionIds"])) {
            $divisionIds = $fields["divisionIds"];
            $currentDivisions = $this->fetchAll(
                sql: "SELECT division_id FROM organization_divisions WHERE organization_id = :organization_id",
                params: ["organization_id" => $id]
            );
            $currentDivisionIds = array_column(array: $currentDivisions, column_key: "division_id");
            $divisionsToAdd = array_diff(array: $divisionIds, arrays: $currentDivisionIds);
            $divisionsToRemove = array_diff(array: $currentDivisionIds, arrays: $divisionIds);
            if (!empty($divisionsToAdd)) {
                $sql = "INSERT INTO organization_divisions (organization_id, division_id) VALUES (:organization_id, :division_id)";
                foreach ($divisionsToAdd as $divisionId) {
                    $this->execute(sql: $sql, params: [
                        "organization_id" => $id,
                        "division_id" => $divisionId
                    ]);
                }
            }
            if (!empty($divisionsToRemove)) {
                $sql = "DELETE FROM organization_divisions WHERE organization_id = :organization_id AND division_id = :division_id";
                foreach ($divisionsToRemove as $divisionId) {
                    $this->execute(sql: $sql, params: [
                        "organization_id" => $id,
                        "division_id" => $divisionId
                    ]);
                }
            }
        }
        return true;
    }
}
