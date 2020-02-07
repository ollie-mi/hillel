<?php
declare(strict_types=1);

const DATABASE_PARAMS = [
    'host'     => '127.0.0.1',
    'user'     => 'root',
    'password' => 'root',
    'database' => 'ecommerce',
];


function get_database_connection(array $parameters): mysqli {
    $database = new mysqli(
        $parameters['host'] ?? null,
        $parameters['user'] ?? null,
        $parameters['password'] ?? null,
        $parameters['database'] ?? null
    );

    if ($database->connect_errno) {
        throw new RuntimeException($database->connect_error);
    }

    return $database;
}

function close_database_connection(mysqli $database): bool {
    return $database->close();
}


function get_products_by_category_id($categoryId): array {

    $database = get_database_connection(DATABASE_PARAMS);

    $query = 'SELECT
    `products`.`id` AS `product_id`,
    `categories`.`name` AS `category_name`,
    `attributes`.`name` AS `attribute_name`,
    `product_attributes_varchar`.`value` AS `attribute_varchar`,
    `product_attributes_text`.`value` AS `attribute_text`,
    `product_attributes_decimal`.`value` AS `attribute_decimal`,
    `product_attributes_int`.`value` AS `attribute_int`,
    `product_attributes_bool`.`value` AS `attribute_bool`
    FROM `categories`
    INNER JOIN `category_attributes`
        ON `category_attributes`.`category_id` = `categories`.`id`
    INNER JOIN `attributes`
        ON `attributes`.`id` = `category_attributes`.`attribute_id`
    LEFT JOIN `products`
        ON `products`.`category_id` = `categories`.`id`
    LEFT JOIN `product_attributes_varchar`
        ON `product_attributes_varchar`.`product_id` = `products`.`id`
           AND `product_attributes_varchar`.`attribute_id` = `attributes`.`id`
    LEFT JOIN `product_attributes_text`
        ON `product_attributes_text`.`product_id` = `products`.`id`
           AND `product_attributes_text`.`attribute_id` = `attributes`.`id`       
    LEFT JOIN `product_attributes_decimal`
        ON `product_attributes_decimal`.`product_id` = `products`.`id`
           AND `product_attributes_decimal`.`attribute_id` = `attributes`.`id`
    LEFT JOIN `product_attributes_int`
        ON `product_attributes_int`.`product_id` = `products`.`id`
           AND `product_attributes_int`.`attribute_id` = `attributes`.`id`
    LEFT JOIN `product_attributes_bool`
        ON `product_attributes_bool`.`product_id` = `products`.`id`
           AND `product_attributes_bool`.`attribute_id` = `attributes`.`id`
    WHERE `categories`.`id` = ' . $database->real_escape_string($categoryId) . '
    ORDER BY `products`.`id`, `category_attributes`.`ordering`';

    $result = $database->query($query);

    if ($database->errno) {
        die($database->error);
    }

    close_database_connection($database);

    return $result->fetch_all(MYSQLI_ASSOC);
}

function filter_products(array $products): array {
    $result = [];
    foreach ($products as $item) {
        $product_id     = $item['product_id'];
        $attribute_name = $item['attribute_name'];
        $category_name  = $item['category_name'];
        unset($item['product_id'], $item['attribute_name'], $item['category_name']);

        if (!isset($result['category_name'])) {
            $result['category_name'] = $category_name;
        }
        foreach ($item as $attribute) {
            if ($attribute !== null) {
                $result[$product_id][$attribute_name] = $attribute;
            }
        }
    }
    return $result;
}

function print_products(array $products): array {
    if (!empty($products)) {
        echo '<h1 align="center">' . $products['category_name'] . '</h1>';
        unset($products['category_name']);
        foreach ($products as $product) {
            echo '<table style="border-collapse: collapse; width: 80%; margin: 0 auto;">';
            foreach ($product as $name => $value) {
                echo '<tr>';
                echo '<td style="border: 1px solid #dddddd; text-align: left; padding: 8px; width: 20%">' . $name . '</td>';
                echo '<td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">' . $value . '</td>';
                echo '</tr><br>';
            }
            echo '</table>';
        }
    } else {
        echo '<div>В данной категории нет товаров!</div>';
    }
}