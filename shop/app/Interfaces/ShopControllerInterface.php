<?php

interface ShopControllerInterface
{
    public function index(): void;

    public function show($id): void;

    public function create(): void;

    public function edit($id): void;

    public function store():void;

    public function toCart(): void;

    public function update(): void;

    public function delete($id): void;

    public function deleteCartItem($id): void;

    public function checkout(): void;

    public function cart(): void;

    public function payments(): void;

    public function logout(): void;

    public function updateCartItem(): void;

    public function redirectLogin(): void;

    public function deleteOrderItem($id): void;
}