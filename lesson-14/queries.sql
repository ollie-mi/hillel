--
-- Получение полной информации о товаре
--

SELECT
    `products`.`id` AS `product_id`,
    `products`.`sku`,
    `categories`.`name` AS `category_name`,
    `attributes`.`name` AS `attribute_name`,
    `product_attributes_varchar`.`value` AS `attribute_varchar`,
    `product_attributes_text`.`value` AS `attribute_text`,
    `product_attributes_int`.`value` AS `attribute_int`,
    `product_attributes_decimal`.`value` AS `attribute_decimal`,
    `product_attributes_bool`.`value` AS `attribute_bool`
FROM `products`
    INNER JOIN `categories`
        ON `products`.`category_id` = `categories`.`id`
    INNER JOIN `category_attributes`
        ON `category_attributes`.`category_id` = `categories`.`id`
    INNER JOIN `attributes`
        ON `attributes`.`id` = `category_attributes`.`attribute_id`
    LEFT JOIN `product_attributes_varchar`
        ON `product_attributes_varchar`.`product_id` = `products`.`id`
           AND `product_attributes_varchar`.`attribute_id` = `attributes`.`id`
    LEFT JOIN `product_attributes_text`
        ON `product_attributes_text`.`product_id` = `products`.`id`
           AND `product_attributes_text`.`attribute_id` = `attributes`.`id`
    LEFT JOIN `product_attributes_int`
        ON `product_attributes_int`.`product_id` = `products`.`id`
           AND `product_attributes_int`.`attribute_id` = `attributes`.`id`
    LEFT JOIN `product_attributes_decimal`
        ON `product_attributes_decimal`.`product_id` = `products`.`id`
           AND `product_attributes_decimal`.`attribute_id` = `attributes`.`id`
    LEFT JOIN `product_attributes_bool`
        ON `product_attributes_bool`.`product_id` = `products`.`id`
           AND `product_attributes_bool`.`attribute_id` = `attributes`.`id`
WHERE `products`.`id` = 1
ORDER BY `products`.`id`, `category_attributes`.`ordering`;

--
-- Получение списка товаров отдельной категории; использовать атрибуты наименование, стоимость и краткое описание.
--

SELECT
    `categories`.`name` AS `category_name`,
    `products`.`id` AS `product_id`,
    `attributes`.`name` AS `attribute_name`,
    `product_attributes_varchar`.`value` AS `attribute_varchar`,
    `product_attributes_decimal`.`value` AS `attribute_decimal`
FROM `categories`
    INNER JOIN `category_attributes`
        ON `category_attributes`.`category_id` = `categories`.`id`
    INNER JOIN `attributes`
        ON `attributes`.`id` = `category_attributes`.`attribute_id`
           AND `attributes`.`code` IN ('name', 'price', 'short_description')
    LEFT JOIN `products`
        ON `products`.`category_id` = `categories`.`id`
    LEFT JOIN `product_attributes_varchar`
        ON `product_attributes_varchar`.`product_id` = `products`.`id`
           AND `product_attributes_varchar`.`attribute_id` = `attributes`.`id`
    LEFT JOIN `product_attributes_decimal`
        ON `product_attributes_decimal`.`product_id` = `products`.`id`
           AND `product_attributes_decimal`.`attribute_id` = `attributes`.`id`
WHERE `categories`.`id` = 2
ORDER BY `products`.`id`, `category_attributes`.`ordering`;


--
-- Измените структуру базы данных таким образом, чтобы товар мог принадлежать более чем одной категории
--

-- создаём новую таблицу связей
CREATE TABLE `product_categories` (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `product_id` bigint(20) UNSIGNED NOT NULL,
    `category_id` bigint(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

-- миграция
INSERT INTO `product_categories` (`product_id`,`category_id`) SELECT `id`, `category_id` FROM `products`

-- удаляем талицу из products
ALTER TABLE `products` DROP COLUMN `category_id`;


--
-- Измените структуру категорий такой образом, чтобы можно было использовать вложенные категории
--

ALTER TABLE `categories` ADD `parent` BIGINT(20) DEFAULT NULL AFTER `name`;