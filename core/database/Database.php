<?php

namespace core\database;

use core\helpers\Helper;
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
    public function __construct($config, $username = 'root', $password = '')
    {
        $dsn = 'mysql:' . http_build_query($config, arg_separator: ';');

        $this->pdo = new PDO($dsn, $username, $password, [
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

    public function containTable(string $tableName): bool
    {
        $result = $this->query(
            "SHOW TABLES LIKE :tableName;",
            [':tableName' => $tableName]
        )->get();

        return $result != 0;
    }

    public function dropAllTables()
    {
        $drop = strtolower(readline("> Warning: Drop all tables in db [y/n]?[n] ")) === "y";

        if (!$drop) die('> Stop build!');

        echo "> Dropping all tables.\n";

        $this->query("
            SET FOREIGN_KEY_CHECKS = 0;
            SET GROUP_CONCAT_MAX_LEN=32768;
            SET @tables = NULL;
            SELECT GROUP_CONCAT('`', table_name, '`') INTO @tables
            FROM information_schema.tables
            WHERE table_schema = (SELECT DATABASE());
            SELECT IFNULL(@tables,'dummy') INTO @tables;
            SET @tables = CONCAT('DROP TABLE IF EXISTS ', @tables);
            PREPARE stmt FROM @tables;
            EXECUTE stmt;
            DEALLOCATE PREPARE stmt;
            SET FOREIGN_KEY_CHECKS = 1;    
        ")->get();
    }

    public static function tryConnection($server, $dbName, $username = 'root', $password = ''): bool
    {
        echo "> Try connect to server.\n";
        $connection = new \mysqli($server, $username, $password);

        if ($connection->connect_error) die("> Connection failed: " . $connection->connect_error);

        echo "> Checking db if is exists.\n";
        $dbIsExists = $connection->query("SHOW DATABASES LIKE '$dbName';")->num_rows != 0;

        if (!$dbIsExists) {
            $createDB = strtolower(readline("> Database not exists. Create DB [y/n]?[n] ")) === "y";

            if (!$createDB) die();

            echo "> Creating database.\n";
            $sql = "CREATE DATABASE IF NOT EXISTS $dbName";

            if (!$connection->query($sql)) {
                echo "> Error creating database: " . $connection->error;
                die();
            }
        }

        mysqli_close($connection);

        return $dbIsExists;
    }
}
