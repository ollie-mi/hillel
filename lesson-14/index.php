<?php
declare(strict_types=1);

header('Content-Type: text/plain');

// 1. Получение полной информации о товаре
$database = new mysqli('127.0.0.1', 'root', 'root', 'ecommerce');

if ($database->connect_errno) {
    die($database->connect_error);
}

// Получение $_GET параметров
$productId  = $_GET['product_id'] ?? null;
$categoryId = $_GET['category_id'] ?? null;

if ($productId === null || $categoryId === null) {
    die('Enter product ID or category ID');
}

if ($productId) {
    $query = "SELECT 
            `products`.`id` AS `product_id`, `products`.`sku`,
            `categories`.`name` AS `category_name`,
            `attributes`.`name` AS `attribute_name`,
            `product_attributes_varchar`.`value` AS `attribute_varchar`,
            `product_attributes_text`.`value` AS `attribute_text`,
            `product_attributes_int`.`value` AS `attribute_int`,
            `product_attributes_decimal`.`value` AS `attribute_decimal`,
            `product_attributes_bool`.`value` AS `attribute_bool`
          FROM `products`
            INNER JOIN `categories` ON `products`.`category_id` = `categories`.`id` 
            INNER JOIN `category_attributes` ON `category_attributes`.`category_id` = `categories`.`id`
            INNER JOIN `attributes` ON `attributes`.`id` = `category_attributes`.`attribute_id`
            LEFT JOIN `product_attributes_varchar` ON `product_attributes_varchar`.`product_id` = `products`.`id` AND `product_attributes_varchar`.`attribute_id` = `attributes`.`id`
            LEFT JOIN `product_attributes_text` ON `product_attributes_text`.`product_id` = `products`.`id` AND `product_attributes_text`.`attribute_id` = `attributes`.`id`
            LEFT JOIN `product_attributes_int` ON `product_attributes_int`.`product_id` = `products`.`id` AND `product_attributes_int`.`attribute_id` = `attributes`.`id`
            LEFT JOIN `product_attributes_decimal` ON `product_attributes_decimal`.`product_id` = `products`.`id` AND `product_attributes_decimal`.`attribute_id` = `attributes`.`id`
            LEFT JOIN `product_attributes_bool` ON `product_attributes_bool`.`product_id` = `products`.`id` AND `product_attributes_bool`.`attribute_id` = `attributes`.`id`
          WHERE `products`.`id` = " . $database->real_escape_string($productId) . "
          ORDER BY `products`.`id`, `category_attributes`.`ordering`";

    $result = $database->query($query);

    if ($database->errno) {
        die($database->error);
    }

    $product = $result->fetch_all(MYSQLI_ASSOC);
    print_r($product);
}


// Закрытие подключения с базой данных
$database->close();