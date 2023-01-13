<?php

interface CartOperationsInterface
{
    public function getCartContent(): bool|array;

    public function createOrder(array $data): int|string;

    public function customerOrders(array $data): int|string;

    public function updateQuantity(array $data = []): void;

    public function getOrderIds(): bool|array;

    public function cartContentCount(): int;

    public function costumerBagTotal(bool|array $cartContent): bool|array;

    public function updateCartItem(array $data): void;

    public function customerOrderDetails(array $customerDetails, array $customerOrders): array;

    public function removeFromCart(): void;

    public function deleteCartContent(mixed $productId): void;

    public function customerOrdersToDatabase(array $customerOrders): void;

    public function deleteOrderItem(mixed $id): void;
}