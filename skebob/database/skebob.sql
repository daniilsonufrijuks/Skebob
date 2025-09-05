-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:4306
-- Время создания: Сен 05 2025 г., 09:38
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `skebob`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin@super.com', '$2y$12$Vs.GZy91Oggy0jsYLXBFiOtSW3RRF1Q1YJPO2gD3i49ua2f0p3Cli', '2025-04-27 06:02:46', '2025-04-27 06:02:46');

-- --------------------------------------------------------

--
-- Структура таблицы `auctions`
--

CREATE TABLE `auctions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `starting_bid` decimal(8,2) NOT NULL,
  `img` varchar(255) NOT NULL,
  `start_time` date DEFAULT NULL,
  `end_time` date DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `auctions`
--

INSERT INTO `auctions` (`id`, `name`, `description`, `starting_bid`, `img`, `start_time`, `end_time`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Mac 1990', 'Mac 1990 pc', 10000.00, 'images/front/1748171783_1739113880_1738502092_maco.jpeg', '2025-05-16', '2025-05-31', 3, '2025-05-25 08:16:23', '2025-05-25 08:16:23');

-- --------------------------------------------------------

--
-- Структура таблицы `bids`
--

CREATE TABLE `bids` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `bid_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE `books` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`id`, `created_at`, `updated_at`, `name`, `description`, `file_path`, `img`) VALUES
(1, '2025-06-27 10:45:49', '2025-06-27 10:45:49', 'Intro to Computers', 'A simple guide to understanding computers.', '/files/pc.pdf', '/files/pc.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `body`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Nice shop', NULL, '2025-06-27 09:40:43', '2025-06-27 09:40:43'),
(2, 'Thank you', NULL, '2025-06-27 09:46:35', '2025-06-27 09:46:35'),
(3, 'Very very nice shop', NULL, '2025-07-10 11:36:42', '2025-07-10 11:36:42'),
(4, 'Thank you!', NULL, '2025-08-26 05:15:35', '2025-08-26 05:15:35');

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `goods_orders`
--

CREATE TABLE `goods_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','processing','completed','cancelled') NOT NULL DEFAULT 'pending',
  `name` varchar(255) NOT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping_address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `goods_orders`
--

INSERT INTO `goods_orders` (`id`, `order_id`, `status`, `name`, `price`, `description`, `image`, `category`, `total_price`, `shipping_address`, `created_at`, `updated_at`) VALUES
(1, 1, 'pending', 'MSI Gaming Laptop', 700.00, 'MSI Gaming Laptop:\n                                Intel Core i7 processor, 4 Ghz, 12 cores, 24 threads\n                                NVIDIA RTX 3060 6 Gb\n                                RAM Fury 16 Gb 3200 Mhz\n                                SSD 1 TB', 'images/front/msilp.jpg', 'Laptop', 700.00, NULL, '2025-04-27 06:03:44', '2025-04-27 06:03:44'),
(2, 2, 'pending', 'Gigabyte Laptop', 900.00, 'Gigabyte Laptop:\n                                Intel Core i9 processor, 7 Ghz, 12 cores, 24 threads\n                                RAM Fury 32 Gb 3200 Mhz\n                                SSD 1 TB', 'images/front/giglp.jpg', 'Laptop', 900.00, NULL, '2025-04-27 06:04:40', '2025-04-27 06:04:40'),
(3, 2, 'pending', 'Intel Core i3', 50.00, 'Intel Core i3 processor, 3 Ghz', 'images/front/inteli3.jpg', 'Component', 50.00, NULL, '2025-04-27 06:04:40', '2025-04-27 06:04:40'),
(4, 3, 'pending', 'Kingston RAM 3200 MHz 8GB', 50.00, 'Kingston RAM 3200 MHz 8GB 1 stick', 'images/front/kingstonram.jpg', 'Component', 50.00, NULL, '2025-05-15 07:43:02', '2025-05-15 07:43:02'),
(5, 4, 'pending', 'MSI Gaming Station', 700.00, 'MSI Gaming Station:\n                                MSI Gaming Station:\n                                Intel Core i5 processor, 5 Ghz\n                                NVIDIA RTX 3060 8 Gb\n                                RAM Fury 32 Gb 3200 Mhz\n                                SSD 1 TB\n                                HDD 2 TB\n                                Power Supply Be quiet 700 W', 'images/front/pc.png', 'Pc', 700.00, NULL, '2025-05-25 08:17:17', '2025-05-25 08:17:17'),
(6, 5, 'pending', 'MSI Gaming Station', 750.00, 'MSI Gaming Station:\n                                MSI Gaming Station:\n                                Intel Core i5 processor, 5 Ghz\n                                NVIDIA RTX 3060 8 Gb\n                                RAM Fury 32 Gb 3200 Mhz\n                                SSD 1 TB\n                                HDD 2 TB\n                                Power Supply Be quiet 700 W', 'images/front/pc.png', 'Pc', 750.00, NULL, '2025-06-05 04:16:02', '2025-06-05 04:16:02'),
(7, 5, 'pending', 'Nvidia RTX 3080', 500.00, 'Nvidia RTX 3080 12 GB', 'images/front/3080.jpg', 'Component', 500.00, NULL, '2025-06-05 04:16:03', '2025-06-05 04:16:03'),
(8, 6, 'pending', 'MSI Gaming Station', 970.00, 'MSI Gaming Station: MSI Gaming Station: Intel Core i7 processor, 5 Ghz NVIDIA RTX 3080 8 Gb RAM Fury 32 Gb 3200 Mhz SSD 1 TB HDD 2 TB Power Supply Be quiet 700 W', 'images/front/1748188525_pc.png', 'Pc', 970.00, NULL, '2025-06-05 04:29:26', '2025-06-05 04:29:26'),
(9, 7, 'pending', 'Kingston RAM 3200 MHz 8GB', 50.00, 'Kingston RAM 3200 MHz 8GB 1 stick', 'images/front/kingstonram.jpg', 'Component', 50.00, NULL, '2025-06-05 04:33:49', '2025-06-05 04:33:49'),
(10, 8, 'pending', 'Google Pixel 9 Pro', 800.00, 'Google pixel 9 Pro phone\r\n512 Gb Rom\r\n12 Gb RAM\r\nSnapdragon Elite G CPU\r\nAdreno 890 GPU\r\n7000 Mah Battery\r\nType C', 'images/front/1750755864_phones.png', 'Phone', 800.00, NULL, '2025-06-24 07:35:45', '2025-06-24 07:35:45'),
(11, 9, 'pending', 'Google Pixel 9 Pro', 800.00, 'Google pixel 9 Pro phone\r\n512 Gb Rom\r\n12 Gb RAM\r\nSnapdragon Elite G CPU\r\nAdreno 890 GPU\r\n7000 Mah Battery\r\nType C', 'images/front/1750755864_phones.png', 'Phone', 800.00, NULL, '2025-06-24 07:37:05', '2025-06-24 07:37:05'),
(12, 10, 'pending', 'Google Pixel 9 Pro', 800.00, 'Google pixel 9 Pro phone\r\n512 Gb Rom\r\n12 Gb RAM\r\nSnapdragon Elite G CPU\r\nAdreno 890 GPU\r\n7000 Mah Battery\r\nType C', 'images/front/1750755864_phones.png', 'Phone', 800.00, NULL, '2025-06-24 07:40:09', '2025-06-24 07:40:09'),
(13, 11, 'pending', 'Google Pixel 9 Pro', 800.00, 'Google pixel 9 Pro phone\r\n512 Gb Rom\r\n12 Gb RAM\r\nSnapdragon Elite G CPU\r\nAdreno 890 GPU\r\n7000 Mah Battery\r\nType C', 'images/front/1750755864_phones.png', 'Phone', 800.00, NULL, '2025-06-24 07:42:00', '2025-06-24 07:42:00'),
(14, 12, 'pending', 'Custom 60%', 100.00, 'Custom 60% keyboard, mechanical, red switches, wireless', 'images/front/1750755707_keyboard.png', 'Peripheral', 100.00, NULL, '2025-06-24 07:46:09', '2025-06-24 07:46:09'),
(15, 13, 'pending', 'Custom 60%', 100.00, 'Custom 60% keyboard, mechanical, red switches, wireless', 'images/front/1750755707_keyboard.png', 'Peripheral', 100.00, NULL, '2025-06-25 11:54:49', '2025-06-25 11:54:49'),
(16, 13, 'pending', 'Custom 60%', 50.00, 'Custom 60% keyboard, red switches, wireless', 'images/front/1750755707_keyboard.png', 'Peripheral', 50.00, NULL, '2025-06-25 11:54:49', '2025-06-25 11:54:49'),
(17, 14, 'pending', 'Custom 60%', 100.00, 'Custom 60% keyboard, mechanical, red switches, wireless', 'images/front/1750755707_keyboard.png', 'Peripheral', 100.00, NULL, '2025-06-25 12:01:51', '2025-06-25 12:01:51'),
(18, 14, 'pending', 'Custom 60%', 50.00, 'Custom 60% keyboard, red switches, wireless', 'images/front/1750755707_keyboard.png', 'Peripheral', 50.00, NULL, '2025-06-25 12:01:51', '2025-06-25 12:01:51'),
(19, 14, 'pending', 'Gigabyte Laptop', 900.00, 'Gigabyte Laptop:\n                                Intel Core i9 processor, 7 Ghz, 12 cores, 24 threads\n                                RAM Fury 32 Gb 3200 Mhz\n                                SSD 1 TB', 'images/front/giglp.jpg', 'Laptop', 900.00, NULL, '2025-06-25 12:01:51', '2025-06-25 12:01:51');

-- --------------------------------------------------------

--
-- Структура таблицы `gpt_traces`
--

CREATE TABLE `gpt_traces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class` varchar(255) NOT NULL,
  `input` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`input`)),
  `model_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`model_response`)),
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `attributes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attributes`)),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_07_20_000000_create_gpt_traces_table', 1),
(5, '2024_12_03_125041_create_orders_table', 1),
(6, '2025_01_16_123853_create_admins_table', 1),
(7, '2025_01_19_161211_create_auctions_table', 1),
(8, '2025_02_09_144714_create_bids_table', 1),
(9, '2025_02_26_164946_create_books_table', 1),
(10, '2025_04_05_083849_create_goods_orders_table', 1),
(11, '2025_04_20_145505_create_products_table', 1),
(12, '2025_04_20_145528_create_poincluded_table', 1),
(13, '2025_06_26_080743_create_comments_table', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `ordered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `status`, `total`, `ordered_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'pending', 700.00, NULL, '2025-04-27 06:03:44', '2025-04-27 06:03:44'),
(2, 1, 'pending', 950.00, NULL, '2025-04-27 06:04:40', '2025-04-27 06:04:40'),
(3, 2, 'pending', 50.00, NULL, '2025-05-15 07:43:02', '2025-05-15 07:43:02'),
(4, 3, 'pending', 700.00, NULL, '2025-05-25 08:17:17', '2025-05-25 08:17:17'),
(5, 8, 'pending', 1250.00, NULL, '2025-06-05 04:16:02', '2025-06-05 04:16:02'),
(6, 8, 'pending', 970.00, NULL, '2025-06-05 04:29:26', '2025-06-05 04:29:26'),
(7, 8, 'pending', 50.00, NULL, '2025-06-05 04:33:49', '2025-06-05 04:33:49'),
(8, 9, 'pending', 800.00, NULL, '2025-06-24 07:35:45', '2025-06-24 07:35:45'),
(9, 9, 'pending', 800.00, NULL, '2025-06-24 07:37:05', '2025-06-24 07:37:05'),
(10, 9, 'pending', 800.00, NULL, '2025-06-24 07:40:09', '2025-06-24 07:40:09'),
(11, 9, 'pending', 800.00, NULL, '2025-06-24 07:42:00', '2025-06-24 07:42:00'),
(12, 9, 'pending', 100.00, NULL, '2025-06-24 07:46:09', '2025-06-24 07:46:09'),
(13, 9, 'pending', 150.00, NULL, '2025-06-25 11:54:49', '2025-06-25 11:54:49'),
(14, 9, 'pending', 1050.00, NULL, '2025-06-25 12:01:51', '2025-06-25 12:01:51');

-- --------------------------------------------------------

--
-- Структура таблицы `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `poincluded`
--

CREATE TABLE `poincluded` (
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `poincluded`
--

INSERT INTO `poincluded` (`order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 15, 1, 700.00, '2025-04-27 06:03:44', '2025-04-27 06:03:44'),
(2, 17, 1, 900.00, '2025-04-27 06:04:40', '2025-04-27 06:04:40'),
(2, 6, 1, 50.00, '2025-04-27 06:04:40', '2025-04-27 06:04:40'),
(3, 12, 1, 50.00, '2025-05-15 07:43:02', '2025-05-15 07:43:02'),
(4, 18, 1, 700.00, '2025-05-25 08:17:17', '2025-05-25 08:17:17'),
(5, 18, 1, 750.00, '2025-06-05 04:16:03', '2025-06-05 04:16:03'),
(5, 10, 1, 500.00, '2025-06-05 04:16:03', '2025-06-05 04:16:03'),
(6, 33, 1, 970.00, '2025-06-05 04:29:26', '2025-06-05 04:29:26'),
(7, 12, 1, 50.00, '2025-06-05 04:33:49', '2025-06-05 04:33:49'),
(8, 35, 1, 800.00, '2025-06-24 07:35:45', '2025-06-24 07:35:45'),
(9, 35, 1, 800.00, '2025-06-24 07:37:05', '2025-06-24 07:37:05'),
(10, 35, 1, 800.00, '2025-06-24 07:40:09', '2025-06-24 07:40:09'),
(11, 35, 1, 800.00, '2025-06-24 07:42:00', '2025-06-24 07:42:00'),
(12, 34, 1, 100.00, '2025-06-24 07:46:09', '2025-06-24 07:46:09'),
(13, 34, 1, 100.00, '2025-06-25 11:54:49', '2025-06-25 11:54:49'),
(13, 40, 1, 50.00, '2025-06-25 11:54:49', '2025-06-25 11:54:49'),
(14, 34, 1, 100.00, '2025-06-25 12:01:51', '2025-06-25 12:01:51'),
(14, 40, 1, 50.00, '2025-06-25 12:01:51', '2025-06-25 12:01:51'),
(14, 17, 1, 900.00, '2025-06-25 12:01:51', '2025-06-25 12:01:51');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `image`, `category`, `admin_id`, `created_at`, `updated_at`) VALUES
(1, 'Intel Core i5F', 105.00, 'Intel Core i5 processor, 5 Ghz', 'images/front/inteli5.png', 'Component', 1, '2025-04-27 06:02:47', '2025-04-27 06:02:47'),
(2, 'Intel Core i7', 200.00, 'Intel Core i7 processor, 6 Ghz', 'images/front/inteli7.jpg', 'Component', 1, '2025-04-27 06:02:47', '2025-04-27 06:02:47'),
(3, 'Intel Core i5', 150.00, 'Intel Core i5 processor, 6 Ghz', 'images/front/inteli5.png', 'Component', 1, '2025-04-27 06:02:47', '2025-04-27 06:02:47'),
(4, 'Intel Core i9', 400.00, 'Intel Core i9 processor, 7 Ghz', 'images/front/inteli9.jpg', 'Component', 1, '2025-04-27 06:02:47', '2025-04-27 06:02:47'),
(5, 'Intel Core i9', 450.00, 'Intel Core i9 processor, 9 Ghz', 'images/front/inteli9.jpg', 'Component', 1, '2025-04-27 06:02:47', '2025-04-27 06:02:47'),
(6, 'Intel Core i3', 50.00, 'Intel Core i3 processor, 3 Ghz', 'images/front/inteli3.jpg', 'Component', 1, '2025-04-27 06:02:47', '2025-04-27 06:02:47'),
(7, 'Adata SSD 1 TB', 70.00, 'Adata SSD 1 TB DISK', 'images/front/adata.jpg', 'Component', 1, '2025-04-27 06:02:47', '2025-04-27 06:02:47'),
(8, 'WD SSD 1 TB', 90.00, 'WD SSD 1 TB DISK', 'images/front/adata.jpg', 'Component', 1, '2025-04-27 06:02:47', '2025-04-27 06:02:47'),
(9, 'Nvidia RTX 3060', 300.00, 'Nvidia RTX 3060 6GB', 'images/front/3060.jpg', 'Component', 1, '2025-04-27 06:02:47', '2025-04-27 06:02:47'),
(10, 'Nvidia RTX 3080', 500.00, 'Nvidia RTX 3080 12 GB', 'images/front/3080.jpg', 'Component', 1, '2025-04-27 06:02:47', '2025-04-27 06:02:47'),
(11, 'Nvidia RTX 3090', 700.00, 'Nvidia RTX 3090 12 GB', 'images/front/3090.jpg', 'Component', 1, '2025-04-27 06:02:47', '2025-04-27 06:02:47'),
(12, 'Kingston RAM 3200 MHz 8GB', 50.00, 'Kingston RAM 3200 MHz 8GB 1 stick', 'images/front/kingstonram.jpg', 'Component', 1, '2025-04-27 06:02:47', '2025-04-27 06:02:47'),
(13, 'Kingston RAM 3200 MHz 16GB', 70.00, 'Kingston RAM 3200 MHz 16GB 1 stick', 'images/front/kingstonram.jpg', 'Component', 1, '2025-04-27 06:02:47', '2025-04-27 06:02:47'),
(14, 'Kingston RAM 3200 MHz 32GB', 80.00, 'Kingston RAM 3200 MHz 32GB 1 stick', 'images/front/kingstonram.jpg', 'Component', 1, '2025-04-27 06:02:47', '2025-04-27 06:02:47'),
(15, 'MSI Gaming Laptop', 600.00, 'MSI Gaming Laptop:\n                                Intel Core i7 processor, 4 Ghz, 12 cores, 24 threads\n                                NVIDIA RTX 3060 6 Gb\n                                RAM Fury 16 Gb 3200 Mhz\n                                SSD 1 TB', 'images/front/msilp.jpg', 'Laptop', 1, '2025-04-27 06:02:47', '2025-05-25 12:56:28'),
(16, 'Asus Gaming Laptop', 870.00, 'Asus Gaming Laptop:\n                                Intel Core i9 processor, 7 Ghz, 12 cores, 24 threads\n                                NVIDIA RTX 3080 6 Gb\n                                RAM Fury 16 Gb 3200 Mhz\n                                SSD 1 TB', 'images/front/asusgl.jpg', 'Laptop', 1, '2025-04-27 06:02:47', '2025-04-27 06:02:47'),
(17, 'Gigabyte Laptop', 900.00, 'Gigabyte Laptop:\n                                Intel Core i9 processor, 7 Ghz, 12 cores, 24 threads\n                                RAM Fury 32 Gb 3200 Mhz\n                                SSD 1 TB', 'images/front/giglp.jpg', 'Laptop', 1, '2025-04-27 06:02:47', '2025-04-27 06:02:47'),
(18, 'MSI Gaming Station', 750.00, 'MSI Gaming Station:\n                                MSI Gaming Station:\n                                Intel Core i5 processor, 5 Ghz\n                                NVIDIA RTX 3060 8 Gb\n                                RAM Fury 32 Gb 3200 Mhz\n                                SSD 1 TB\n                                HDD 2 TB\n                                Power Supply Be quiet 700 W', 'images/front/pc.png', 'Pc', 1, '2025-04-27 06:02:47', '2025-05-25 12:56:52'),
(33, 'MSI Gaming Station', 970.00, 'MSI Gaming Station: MSI Gaming Station: Intel Core i7 processor, 5 Ghz NVIDIA RTX 3080 8 Gb RAM Fury 32 Gb 3200 Mhz SSD 1 TB HDD 2 TB Power Supply Be quiet 700 W', 'images/front/1748188525_pc.png', 'Pc', 1, '2025-05-25 12:55:25', '2025-05-25 12:59:02'),
(34, 'Custom 60%', 100.00, 'Custom 60% keyboard, mechanical, red switches, wireless', 'images/front/1750755707_keyboard.png', 'Peripheral', 1, '2025-06-24 06:01:47', '2025-06-24 06:01:47'),
(35, 'Google Pixel 9 Pro', 800.00, 'Google pixel 9 Pro phone\r\n512 Gb Rom\r\n12 Gb RAM\r\nSnapdragon Elite G CPU\r\nAdreno 890 GPU\r\n7000 Mah Battery\r\nType C', 'images/front/1750755864_phones.png', 'Phone', 1, '2025-06-24 06:04:24', '2025-06-24 06:04:24'),
(36, 'Custom 60%', 150.00, 'Custom 60% keyboard, mechanical, blue switches, wireless', 'images/front/1750755707_keyboard.png', 'Peripheral', 1, '2025-06-24 06:01:47', '2025-06-24 06:01:47'),
(37, 'Custom 60%', 150.00, 'Custom 60% keyboard, mechanical, green switches, wireless', 'images/front/1750755707_keyboard.png', 'Peripheral', 1, '2025-06-24 06:01:47', '2025-06-24 06:01:47'),
(38, 'Custom 70%', 150.00, 'Custom 70% keyboard, mechanical, red switches, wireless', 'images/front/1750755707_keyboard.png', 'Peripheral', 1, '2025-06-24 06:01:47', '2025-06-24 06:01:47'),
(39, 'Custom 60%', 200.00, 'Custom 60% keyboard, magnetic switches, wireless', 'images/front/1750755707_keyboard.png', 'Peripheral', 1, '2025-06-24 06:01:47', '2025-06-24 06:01:47'),
(40, 'Custom 60%', 50.00, 'Custom 60% keyboard, red switches, wireless', 'images/front/1750755707_keyboard.png', 'Peripheral', 1, '2025-06-24 06:01:47', '2025-06-24 06:01:47'),
(41, 'Custom 60%', 30.00, 'Custom 60% keyboard, red switches, type-c cable', 'images/front/1750755707_keyboard.png', 'Peripheral', 1, '2025-06-24 06:01:47', '2025-06-24 06:01:47'),
(42, 'Google Pixel 9 Ultra', 900.00, 'Google pixel 9 Ultra phone\r\n512 Gb Rom\r\n16 Gb RAM\r\nSnapdragon Elite G CPU\r\nAdreno 890 GPU\r\n7500 Mah Battery\r\nType C', 'images/front/1750755864_phones.png', 'Phone', 1, '2025-06-24 06:04:24', '2025-06-24 06:04:24'),
(43, 'Google Pixel 9', 700.00, 'Google pixel 9 phone\r\n256 Gb Rom\r\n8 Gb RAM\r\nSnapdragon Elite G CPU\r\nAdreno 890 GPU\r\n5000 Mah Battery\r\nType C', 'images/front/1750755864_phones.png', 'Phone', 1, '2025-06-24 06:04:24', '2025-06-24 06:04:24'),
(44, 'MSI Gaming Laptop Pro', 1000.00, 'MSI Gaming Laptop:\r\n                                Intel Core i9 processor, 4 Ghz, 16 cores, 24 threads\r\n                                NVIDIA RTX 3060 8 Gb\r\n                                RAM Fury 16 Gb 3200 Mhz\r\n                                SSD 2 TB', 'images/front/msilp.jpg', 'Laptop', 1, '2025-04-27 06:02:47', '2025-05-25 12:56:28'),
(45, 'MSI Gaming Laptop Lite', 500.00, 'MSI Gaming Laptop:\r\n                                Intel Core i5 processor, 4 Ghz, 10 cores, 20 threads\r\n                                NVIDIA RTX 3060 4 Gb\r\n                                RAM Fury 16 Gb 3200 Mhz\r\n                                SSD 2 TB', 'images/front/msilp.jpg', 'Laptop', 1, '2025-04-27 06:02:47', '2025-05-25 12:56:28'),
(46, 'Sony Studio', 70.00, 'Sony Studio Pro Headphones', 'images/front/1750924746_sony.png', 'Peripheral', 1, '2025-06-26 04:59:06', '2025-06-26 04:59:06'),
(47, 'Sony Studio Ultra', 90.00, 'Sony Studio Pro Headphones', 'images/front/1750924746_sony.png', 'Peripheral', 1, '2025-06-26 04:59:06', '2025-06-26 04:59:06'),
(48, 'Sony Studio Wireless', 50.00, 'Sony Studio Pro Headphones', 'images/front/1750924746_sony.png', 'Peripheral', 1, '2025-06-26 04:59:06', '2025-06-26 04:59:06'),
(49, 'Logitech G Pro', 120.00, 'Logitech G Pro Mouse', 'images/front/1750924976_logi.png', 'Peripheral', 1, '2025-06-26 05:02:56', '2025-06-26 05:02:56'),
(50, 'Leo Table Pro', 200.00, 'Leo Table Pro 1.5 x 1 x 2 m', 'images/front/1752158103_table.png', 'Furniture', 1, '2025-07-10 11:35:03', '2025-07-10 11:35:03'),
(51, 'Power Cable', 20.00, 'Power Cable for power supplies from 200 to 700 w', 'images/front/1752158167_cables.png', 'Cable', 1, '2025-07-10 11:36:07', '2025-07-10 11:36:07');

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0ucM3mu3dhzs3XsXl9TxpOHFHinwbEaqDpVsk84z', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRWhta0xmRXprd1JFbnVObkpjRzg1OFprcWZBUUhXZ1pLUUJ4Q2FaWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Njc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWN0cy9sYXB0b3BzP3ByaWNlX21heD0xMDAwMDAmcHJpY2VfbWluPTAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756216329);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'johndoe', 'johndoe@gmail.com', NULL, '$2y$12$CxAVn/AIQsjPZiFKG5GFu.fEx4cO8wOWH2f7ZAlXqJMZRi7AV9irC', NULL, '2025-04-27 06:03:14', '2025-04-27 06:03:14'),
(2, 'igor', 'igor@gmail.com', NULL, '$2y$12$e2g1Owb1styaeIdPe/m92OpEaAHyXenGMcA8YNHrxFabGpi/JjKby', NULL, '2025-05-15 07:39:42', '2025-05-15 07:39:42'),
(3, 'rvt', 'rvt@gmail.com', NULL, '$2y$12$jPxR/QjacCOyr6dv.sJEVezgN.170e2O9ElLtewTj77K9n2GkFikS', NULL, '2025-05-25 08:15:11', '2025-05-25 08:15:11'),
(4, 'donufrijuks', 'donufrijuks@gmail.com', NULL, '$2y$12$FiXc4Mb/i/NtMXokjqI/.eBGodARvWNcBbhEsUwy/80dAnFJ.BgC.', NULL, '2025-06-05 03:44:41', '2025-06-05 03:44:41'),
(5, 'freemen1094', 'freemen1094@gmail.com', NULL, '$2y$12$O.k/JwU8ylbUlmulbfzYTOJ6XRE/HNoHZq3sBnWN/EaKvuT.qTUqa', NULL, '2025-06-05 03:47:49', '2025-06-05 03:47:49'),
(6, 'dhl', 'dhl@gmail.com', NULL, '$2y$12$Gbds2d0rYJELIAipqmh/nuRcjgnwvp7bA9eWOwuLDG8wG7OzfckRq', NULL, '2025-06-05 03:49:50', '2025-06-05 03:49:50'),
(7, 'asin', 'asin@gmail.com', NULL, '$2y$12$p6m2CmKtItJSN6Z2KdiAJ.Uuuw9s9YU9/sW6RZgPE52CLjdj6wiF6', NULL, '2025-06-05 04:05:10', '2025-06-05 04:05:10'),
(8, 'kms', 'kms@gmail.com', NULL, '$2y$12$MpXpo4yDiAq3PJMAFlyp/eWYmH1TCEhgch0mR0.vjRQ2GRu0p381.', NULL, '2025-06-05 04:10:37', '2025-06-05 04:10:37'),
(9, 'g', 'g@gmail.com', NULL, '$2y$12$scke6DlNfV7ydwerRaOodejJCv.DpT0zGoM9Azrm7dvvQ/IagPHgG', NULL, '2025-06-24 07:35:37', '2025-06-24 07:35:37');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `auctions`
--
ALTER TABLE `auctions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auctions_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `bids`
--
ALTER TABLE `bids`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bids_user_id_foreign` (`user_id`),
  ADD KEY `bids_item_id_foreign` (`item_id`);

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Индексы таблицы `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `goods_orders`
--
ALTER TABLE `goods_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goods_orders_order_id_foreign` (`order_id`);

--
-- Индексы таблицы `gpt_traces`
--
ALTER TABLE `gpt_traces`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Индексы таблицы `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Индексы таблицы `poincluded`
--
ALTER TABLE `poincluded`
  ADD KEY `poincluded_order_id_foreign` (`order_id`),
  ADD KEY `poincluded_product_id_foreign` (`product_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_admin_id_foreign` (`admin_id`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `auctions`
--
ALTER TABLE `auctions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `bids`
--
ALTER TABLE `bids`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `goods_orders`
--
ALTER TABLE `goods_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `gpt_traces`
--
ALTER TABLE `gpt_traces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `auctions`
--
ALTER TABLE `auctions`
  ADD CONSTRAINT `auctions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `bids`
--
ALTER TABLE `bids`
  ADD CONSTRAINT `bids_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `auctions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bids_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `goods_orders`
--
ALTER TABLE `goods_orders`
  ADD CONSTRAINT `goods_orders_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `poincluded`
--
ALTER TABLE `poincluded`
  ADD CONSTRAINT `poincluded_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `poincluded_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
