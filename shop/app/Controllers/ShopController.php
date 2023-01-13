<?php
declare(strict_types = 1);

use JetBrains\PhpStorm\NoReturn;
require_once __DIR__.'/../Models/CartOperations.php';
require_once __DIR__.'/../Models/Shop.php';
require_once __DIR__.'/../../app/Traits/UploadFiles.php';
require_once __DIR__.'/../Authenticate/Authenticate.php';
require_once __DIR__.'/../../app/Interfaces/ShopControllerInterface.php';

class ShopController extends Authenticate implements ShopControllerInterface
{
    use UploadFiles;

    public function index(): void
    {
        $product = new Shop();
        $products = $product->getAll();
        view(__DIR__.'/../../view/shop/index.php', compact('products'));
    }

    public function show($id): void
    {
        $product = new Shop();
        $products = $product->get($id);
        view(__DIR__.'/../../view/shop/single_product.php', compact('products'));
    }

    public function create(): void
    {
        $product = new Shop();
        $products = $product->getAll();
        view(__DIR__.'/../../view/shop/create.php', compact('products'));
    }

    public function edit($id): void
    {
        $products = new Shop();
        $product = $products->get($id);
        view(__DIR__.'/../../view/shop/edit.php', compact('product'));
    }

    #[NoReturn] public function store(): void
    {
        $imageName = $this->upload($_FILES['image'], '../storage/images/');
        $_REQUEST['image'] = $imageName;
        $product = new Shop();
        $product->create($_REQUEST);
        redirect('/shop/create');
    }

    #[NoReturn] public function toCart(): void
    {
        $product = new CartOperations();
        $product->createOrder($_REQUEST);
        redirect('/shop/'.$_REQUEST['product_id']);
    }

    #[NoReturn] public function update(): void
    {
        $_POST['image'] = $this->upload($_FILES['image'], '../storage/images/');
        $product = new Shop();
        $product->update($_POST);
        redirect('/shop/create');
    }

    #[NoReturn] public function delete($id): void
    {
        if(!($_SESSION['authenticated'] ?? '')) {
            redirect('/shop/login');
        }
        $product = new Shop();
        $product->delete($id);
        redirect('/shop/create');
    }

    #[NoReturn] public function deleteCartItem($id): void
    {
        $product = new Shop();
        $product->deleteCartItem($id);
        redirect('/shop/cart');
    }
    #[NoReturn] public function deleteOrderItem($id): void
    {
        $product = new CartOperations();
        $product->deleteOrderItem($id);
        redirect('/shop/orders');
    }

    public function checkout(): void
    {
        $cart = new CartOperations();
        $orderDetails = $cart->getCartContent();
        $products = $cart->costumerBagTotal($orderDetails);
        view(__DIR__.'/../../view/shop/checkout.php', compact('products'));
    }

    public function cart(): void
    {
        $product = new CartOperations();
        $cartContent = $product->getCartContent();
        $products = $product->costumerBagTotal($cartContent);
        view(__DIR__.'/../../view/shop/cart.php', compact('products'));
    }

    public function orders(): void
    {
        $product = new CartOperations();
        $cartContent = $product->ordersPayed();
        $products = $product->costumerBagTotal($cartContent);
        view(__DIR__.'/../../view/shop/orders.php', compact('products'));
    }

    public function payments(): void
    {
        $product = new CartOperations();
        $cartContent = $product->getCartContent();
        $customerOrders = $product->customerOrderDetails($_REQUEST, $cartContent);
        $product->customerOrdersToDatabase($customerOrders);
        $shop = new Shop();
        $shop->subtractFromStock($customerOrders);
        $product->removeFromCart();
        view(__DIR__.'/../../view/shop/payments.php', compact('cartContent'));
    }

    #[NoReturn] public function logout(): void
    {
        session_destroy();
        redirect('/shop');
    }

    #[NoReturn] public function updateCartItem(): void
    {
        $product = new CartOperations();
        $product->updateCartItem($_REQUEST);
        redirect('/shop/cart');
    }

    #[NoReturn] public function redirectLogin(): void
    {
        redirect('/login.php');
    }
}