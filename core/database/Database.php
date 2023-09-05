<?php

namespace core\database;

use core\routes\Response;
use PDO;
use PDOException;
use PDOStatement;

class Database
{
    private PDO $pdo;
    private bool|PDOStatement $statement;

    /**
     * @throws PDOException if the attempt to connect to the requested database fails.
     */
    public function __construct($config, $user = 'root', $password = '')
    {
        $dsn = 'mysql:' . http_build_query($config, arg_separator: ';');

        $this->pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public function query(string $query, $params = []): static
    {
        $this->statement = $this->pdo->prepare($query);

        $this->statement->execute($params);

        return $this;
    }

    public function findOrFail(): mixed
    {
        $result = $this->find();

        if (!$result) Response::abort();

        return $result;
    }

    public function find(): mixed
    {
        return $this->statement->fetch();
    }

    public function get(): array|int
    {
        $result = $this->statement->fetchAll();


        return empty($result) ? $this->statement->rowCount() : $result;
    }
}