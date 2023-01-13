<?php
declare(strict_types = 1);

require_once __DIR__  . "/../../core/Connections.php";
require_once __DIR__.'/../../app/Interfaces/UserInterface.php';

class User extends Connections implements UserInterface
{

    public string $users = 'users';

    public function getAll(): array
    {
        return $this->connection->query("SELECT * FROM {$this->users}")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($id): array|bool
    {
        $sql = "SELECT * FROM {$this->users} WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getByCredentials($id): array|bool
    {
        $sql = "SELECT * FROM {$this->users} WHERE email = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
}