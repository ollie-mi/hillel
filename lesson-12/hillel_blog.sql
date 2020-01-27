--
-- Создание базы данных
--

CREATE DATABASE `hillel_blog` DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE `hillel_blog`.`users` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(120) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `name` VARCHAR(80) NOT NULL,
    `age` DATE NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY (`email`)
) ENGINE = InnoDB;

CREATE TABLE `hillel_blog`.`posts` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `content` LONGTEXT NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `hillel_blog`.`comments` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT NOT NULL,
    `post_id` BIGINT NOT NULL,
    `content` LONGTEXT NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `hillel_blog`.`likes` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT NOT NULL,
    `post_id` BIGINT NOT NULL,
    `is_active` ENUM('ON','OFF') NOT NULL DEFAULT 'ON',
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

ALTER TABLE `hillel_blog`.`users` CHANGE `age` `birthdate` DATE NOT NULL;

ALTER TABLE `hillel_blog`.`users` ADD `ip_address` INT UNSIGNED NULL AFTER `birthdate`;

ALTER TABLE `hillel_blog`.`posts` ADD `slug` VARCHAR(255) NULL AFTER `title`;

--
-- Наполнение базы данных
--

INSERT INTO `hillel_blog`.`users`
(`email`, `password`, `name`, `birthdate`, `ip_address`) VALUES
    ('admin@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'admin', '1982-11-12', INET_ATON('202.53.172.138')),
    ('editor@gmail.com', '01cfcd4f6b8770febfb40cb906715822', 'editor', '1993-10-05', INET_ATON('132.188.40.45')),
    ('user@gmail.com', '922d6e97a841438230c5bced5fa6e487', 'user', '1997-03-11', INET_ATON('176.181.247.109'));

INSERT INTO `hillel_blog`.`posts`
(`user_id`, `title`, `content`) VALUES
    (1, 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
    labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
    Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
    (3, 'Curabitur pretium tincidunt lacus', 'Curabitur pretium tincidunt lacus. Nulla gravida orci a odio. Nullam varius,
    turpis et commodo pharetra, est eros bibendum elit, nec luctus magna felis sollicitudin mauris. Integer in mauris eu nibh euismod gravida.
    Duis ac tellus et risus vulputate vehicula. Donec lobortis risus a elit. Etiam tempor. Ut ullamcorper, ligula eu tempor congue, eros est euismod turpis,
    id tincidunt sapien risus a quam. Maecenas fermentum consequat mi. Donec fermentum. Pellentesque malesuada nulla a mi. Duis sapien sem, aliquet nec, commodo eget,
    consequat quis, neque. Aliquam faucibus, elit ut dictum aliquet, felis nisl adipiscing sapien, sed malesuada diam lacus eget erat. Cras mollis scelerisque nunc.
    Nullam arcu. Aliquam consequat. Curabitur augue lorem, dapibus quis, laoreet et, pretium ac, nisi. Aenean magna nisl, mollis quis, molestie eu, feugiat in, orci.
    In hac habitasse platea dictumst.');

INSERT INTO `hillel_blog`.`comments`
(`user_id`, `post_id`, `content`) VALUES
    (2, '1', 'Good post!');

INSERT INTO `hillel_blog`.likes
(`user_id`, `post_id`, `is_active`) VALUES
    (3, 1, 'ON'),
    (2,1,'OFF');





