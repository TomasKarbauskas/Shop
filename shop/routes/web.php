<?php
session_start();

require_once __DIR__."/../core/Router.php";
require_once __DIR__."/../helpers.php";

$router = new Router();

$router->get('/', ['/app/Controllers/ShopController', 'index']);
$router->get('/shop', ['/app/Controllers/ShopController', 'index']);
$router->get('/shop/create', ['/app/Controllers/ShopController', 'create']);
$router->get('/shop/logout', ['/app/Controllers/ShopController', 'logout']);
$router->get('/shop/cart', ['/app/Controllers/ShopController', 'cart']);
$router->get('/shop/checkout', ['/app/Controllers/ShopController', 'checkout']);
$router->get('/shop/{id}', ['/app/Controllers/ShopController', 'show']);
$router->get('/shop/{id}/edit', ['/app/Controllers/ShopController', 'edit']);
$router->get('/shop/login', ['/app/Controllers/ShopController', 'redirectLogin']);
$router->get('/shop/orders', ['/app/Controllers/ShopController', 'orders']);

$router->post('/shop/payments', ['/app/Controllers/ShopController', 'payments']);
$router->post('/shop/update', ['/app/Controllers/ShopController', 'update']);
$router->post('/shop/store', ['/app/Controllers/ShopController', 'store']);
$router->post('/shop/toCart', ['/app/Controllers/ShopController', 'toCart']);
$router->post('/shop/checkout', ['/app/Controllers/ShopController', 'customerOrders']);
$router->post('/shop/updateCartItem', ['/app/Controllers/ShopController', 'updateCartItem']);

$router->delete('/shop/{id}', ['/app/Controllers/ShopController', 'delete']);
$router->delete('/shop/{id}/deleteCartItem', ['/app/Controllers/ShopController', 'deleteCartItem']);
$router->delete('/shop/{id}/deleteOrderItem', ['/app/Controllers/ShopController', 'deleteOrderItem']);
$router->resolve();
