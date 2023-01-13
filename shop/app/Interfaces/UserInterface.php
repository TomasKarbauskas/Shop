<?php

interface UserInterface
{
    public function getAll(): array;

    public function get($id): array|bool;

    public function getByCredentials($id): array|bool;
}