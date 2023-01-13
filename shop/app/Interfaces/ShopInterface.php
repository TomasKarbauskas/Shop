<?php

interface ShopInterface
{
    public function getAll(): bool|array;

    public function get($id): bool|array;

    public function create(array $data): void;

    public function update(array $data = []): void;

    public function delete($id): void;

    public function deleteCartItem($id): void;

    public function subtractFromStock(array $data): void;
}