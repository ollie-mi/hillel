<?php
declare(strict_types=1);

header('Content-Type: text/plain');

$database = new mysqli('127.0.0.1', 'root', 'fry57ster', 'ecommerce');

if ($database->connect_errno) {
    die($database->connect_error);
}

// Получение $_GET параметров
$userId = $_GET['product_id'] ?? null;

if ($userId === null) {
    die('Enter product ID');
}

$query = '';
$result = $database->query($query);

if ($database->errno) {
    die($database->error);
}

$product = $result->fetch_all(MYSQLI_ASSOC);
var_dump($product);




// Закрытие подключения с базой данных
$database->close();
