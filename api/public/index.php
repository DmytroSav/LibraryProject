<?php
require "../src/bootstrap.php";

use App\Controllers\LibraryController;
use App\Controllers\AuthController;
use App\Controllers\UserController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

if ($uri[1] !== 'books' && $uri[1] !== 'register' && $uri[1] !== 'login' && $uri[1] !== 'user') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

// the user id is, of course, optional and must be a number:
$id = null;
if (isset($uri[2])) {
    $id = (int) $uri[2];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

if($uri[1] == 'books')
$controller = new LibraryController($dbConnection, $requestMethod, $id);
else if($uri[1] == 'register' || $uri[1] == 'login')
$controller = new AuthController($dbConnection, $requestMethod, $id);
else if($uri[1] == 'user')
$controller = new UserController($dbConnection, $requestMethod);

$controller->processRequest();