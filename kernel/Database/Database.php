<?php

namespace App\Kernel\Database;

use App\Kernel\Config\ConfigInterface;
use App\Kernel\Database\DatabaseInterface;
use PDO;
use PDOException;

class Database implements DatabaseInterface
{
    private PDO $pdo;
    
    public function __construct(
        private ConfigInterface $config
    )
    {
        $this->connect();
    }
    
    public function insert(string $table, array $data): int|false
    {
        $fields = array_keys($data);

        $columns = implode(', ', $fields);
        $binds = implode(', ', array_map(fn($field) => ":$field", $fields));

        //dd($columns, $binds);

        $sql = "INSERT INTO $table ($columns) VALUES ($binds)";

        $stmt = $this->pdo->prepare($sql);
        
        try {
            $stmt->execute($data);
        } catch (PDOException $e) {
            return false;
        }

        return (int)$this->pdo->lastInsertId();    
    }

    public function first(string $table, array $conditions = []): ?array
    {
        $where = '';

        if(count($conditions) > 0)
        {
            $where = 'WHERE ' . implode(' AND ', array_map(fn($field) => "$field = :$field", array_keys($conditions)));

            $sql = "SELECT * FROM $table $where LIMIT 1";

            $stmt = $this->pdo->prepare($sql);

            $stmt->execute($conditions);

            $result = $stmt->fetch();

            return $result ?: null;

        }
    }    

    public function get(string $table, array $conditions = []): array
    {
        $where = '';

        if(count($conditions) > 0)
        {
            $where = 'WHERE ' . implode(' AND ', array_map(fn($field) => "$field = :$field", array_keys($conditions)));
        }

        $sql = "SELECT * FROM $table $where";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($conditions);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function delete(string $table, array $conditions = []): void
    {
        $where = '';

        if (count($conditions) > 0) {
            $where = 'WHERE ' . implode(' AND ', array_map(fn ($field) => "$field = :$field", array_keys($conditions)));
        }

        $sql = "DELETE FROM $table $where";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($conditions);        
    }

    public function update(string $table, array $data, array $conditions = []): void
    {
        $fields = array_keys($data);

        $set = implode(', ', array_map(fn($field) => "$field = :$field", $fields));

        $where = '';

        if(count($conditions) > 0)
            $where = 'WHERE ' . implode(' AND ', array_map(fn($field) => "$field = :$field", array_keys($conditions)));

        $sql = "UPDATE $table SET $set $where";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(array_merge($data, $conditions));
    }

    private function connect(): void
    {
        $host = $this->config->get('database.host');

        $dbname = $this->config->get('database.dbname');

        $charset = $this->config->get('database.charset');

        $username = $this->config->get('database.username');

        $password = $this->config->get('database.password');

        $options = [
            //    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];

        try {
            $this->pdo = new \PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $username, $password, $options);
        } catch (\PDOException $exception) {
            exit('Ошибка базы данных: ' . $exception->getMessage());
        }
    }
}