<?php
session_start();

require_once __DIR__.'/../helpers.php';
require_once __DIR__ . '/../app/Models/User.php';
require_once __DIR__."/../app/Authenticate/Authenticate.php";

$auth = new Authenticate();

if(($_SESSION['authenticated'] ?? '') && $_SESSION['authenticated'] == 1){
    redirect('/shop/create');
}

if($_POST){
    $auth->login($_POST);
} else {
    view(__DIR__ . '/../view/app/authenticate/login_form.php');
}