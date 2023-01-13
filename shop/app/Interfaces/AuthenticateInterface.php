<?php

interface AuthenticateInterface
{
    public function login(array $credentials): void;

    public function setAuthenticated(array $model): void;

    public function loginInputValidation(array $credentials): void;
}