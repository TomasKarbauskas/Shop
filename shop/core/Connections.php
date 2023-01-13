<?php
declare(strict_types = 1);

class Connections {

    protected object $connection;

    public function __construct() {
        $this->connect();
    }

    private function connect(): void {

        $serverName = 'localhost:3306';
        $username = 'root';
        $password = 'tomas0711';
        $database = 'shop';

        try {
            $this->connection = new PDO("mysql:host=$serverName;dbname=$database", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed'. $e->getMessage();
        }
    }
}