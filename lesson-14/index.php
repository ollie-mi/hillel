<?php
declare(strict_types=1);

require_once __DIR__ . '/functions/functions.php';

// Получение $_GET параметров
$categoryId = $_GET['category_id'] ?? null;

if ($categoryId === null) {
    die('Enter category ID');
}

$products = get_products_by_category_id($categoryId);

$filtered_products = filter_products($products);

print_products($filtered_products);
