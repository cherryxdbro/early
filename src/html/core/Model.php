<?php

class Model
{
    protected $db;

    public function __construct()
    {
        $dsn = "sqlsrv:Server=database,6400;Database=early;TrustServerCertificate=true";
        $username = "sa";
        $password = file_get_contents(filename: "/run/secrets/database-password");
        $this->db = new PDO(dsn: $dsn, username: $username, password: $password, options: [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    protected function query(string $sql, array $params = []): bool|PDOStatement
    {
        $stmt = $this->db->prepare(query: $sql);
        $stmt->execute(params: $params);
        return $stmt;
    }

    protected function fetch(string $sql, array $params = []): mixed
    {
        return $this->query(sql: $sql, params: $params)->fetch();
    }

    protected function fetchAll(string $sql, array $params = []): array
    {
        return $this->query(sql: $sql, params: $params)->fetchAll();
    }

    protected function execute(string $sql, array $params = []): bool|PDOStatement
    {
        return $this->query(sql: $sql, params: $params);
    }
}
