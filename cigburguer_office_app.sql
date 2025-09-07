-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 07-Set-2025 às 01:45
-- Versão do servidor: 8.0.39
-- versão do PHP: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dados: `cigburguer_office_app`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE DATABASE cigburguer_office_app;
USE cigburguer_office_app;

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-01-10-095429', 'App\\Database\\Migrations\\RestaurantsTable', 'default', 'App', 1738102784, 1),
(2, '2025-01-10-204523', 'App\\Database\\Migrations\\UserTable', 'default', 'App', 1738102784, 1),
(3, '2025-01-18-125706', 'App\\Database\\Migrations\\ProductTable', 'default', 'App', 1738102784, 1),
(5, '2025-01-26-213514', 'App\\Database\\Migrations\\StocksTable', 'default', 'App', 1738268175, 2),
(6, '2025-02-13-093138', 'App\\Database\\Migrations\\UpdateRestaurantsTable', 'default', 'App', 1739444582, 3),
(7, '2025-02-13-192339', 'App\\Database\\Migrations\\OrdersTable', 'default', 'App', 1739475366, 4),
(8, '2025-02-13-192353', 'App\\Database\\Migrations\\OrderProductsTable', 'default', 'App', 1739475366, 4),
(9, '2025-03-05-201522', 'App\\Database\\Migrations\\UpdateOrderTable', 'default', 'App', 1741206030, 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `id_restaurant` int UNSIGNED DEFAULT NULL,
  `machine_id` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order_number` int UNSIGNED DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `order_status` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT '0.00',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `orders`
--

INSERT INTO `orders` (`id`, `id_restaurant`, `machine_id`, `order_number`, `order_date`, `order_status`, `total_price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'SALOMAOBE', 1, '2025-03-10 00:19:44', 'paid', 16.50, '2025-03-10 00:44:19', NULL, NULL),
(2, 1, 'SALOMAOBE', 2, '2025-03-10 00:24:46', 'paid', 19.50, '2025-03-10 00:46:24', NULL, NULL),
(3, 1, 'SALOMAOBE', 3, '2025-03-10 01:39:08', 'cancelled', 33.20, '2025-03-10 01:08:39', NULL, '2025-05-29 16:34:51');

-- --------------------------------------------------------

--
-- Estrutura da tabela `order_products`
--

CREATE TABLE `order_products` (
  `id` bigint UNSIGNED NOT NULL,
  `id_order` bigint UNSIGNED DEFAULT NULL,
  `id_product` int UNSIGNED DEFAULT NULL,
  `price_per_unit` decimal(10,2) DEFAULT NULL,
  `quantity` tinyint UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `order_products`
--

INSERT INTO `order_products` (`id`, `id_order`, `id_product`, `price_per_unit`, `quantity`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 13, 2.00, 3, '2025-03-10 00:44:19', NULL, NULL),
(2, 1, 16, 3.50, 3, '2025-03-10 00:44:19', NULL, NULL),
(3, 2, 13, 2.00, 3, '2025-03-10 00:46:24', NULL, NULL),
(4, 2, 16, 3.50, 3, '2025-03-10 00:46:24', NULL, NULL),
(5, 2, 14, 1.50, 2, '2025-03-10 00:46:24', NULL, NULL),
(6, 3, 4, 13.20, 1, '2025-03-10 01:08:39', NULL, NULL),
(7, 3, 13, 2.00, 2, '2025-03-10 01:08:39', NULL, NULL),
(8, 3, 24, 8.00, 2, '2025-03-10 01:08:39', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `products`
--

CREATE TABLE `products` (
  `id` int UNSIGNED NOT NULL,
  `id_restaurant` int UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `category` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT '0.00',
  `availability` tinyint(1) NOT NULL DEFAULT '1',
  `promotion` decimal(5,2) DEFAULT '0.00',
  `stock` int DEFAULT '0',
  `stock_min_limit` int DEFAULT '10',
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `products`
--

INSERT INTO `products` (`id`, `id_restaurant`, `name`, `description`, `category`, `price`, `availability`, `promotion`, `stock`, `stock_min_limit`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Cig Hamburger', 'O melhor hambúrguer pelo melhor preço.', 'Hambúrgueres', 6.50, 1, 0.00, 1090, 100, 'rest_00001_20250129_091414_burger_01.png', '2025-01-28 22:23:23', '2025-05-27 19:00:19', NULL),
(2, 1, 'Cig Cheese In', 'O sabor do queijo dentro do hambúrguer.', 'Hambúrgueres', 8.00, 1, 10.00, 5400, 100, 'rest_00001_20250129_091425_burger_02.png', '2025-01-28 22:23:23', '2025-02-02 19:58:45', NULL),
(3, 1, 'Cig Double', 'Duas vezes mais sabor.', 'Hambúrgueres', 12.50, 1, 0.00, 290, 100, 'rest_00001_20250129_091437_burger_03.png', '2025-01-28 22:23:23', '2025-01-29 09:14:37', NULL),
(4, 1, 'Cig Double Cheese', 'Duas vezes mais queijo e mais sabor.', 'Hambúrgueres', 13.20, 1, 0.00, 4000, 100, 'rest_00001_20250129_091504_burger_04.png', '2025-01-28 22:23:23', '2025-02-01 19:13:37', NULL),
(5, 1, 'Cig Bacon Strike', 'Um hambúrguer com bacon estaladiço.', 'Hambúrgueres', 11.50, 1, 0.00, 1000, 100, 'rest_00001_20250129_091516_burger_05.png', '2025-01-28 22:23:23', '2025-01-29 09:15:16', NULL),
(6, 1, 'Cig Royale', 'Uma hambúrguer ao estilo casa real.', 'Hambúrgueres', 13.00, 1, 0.00, 1000, 100, 'rest_00001_20250129_091527_burger_07.png', '2025-01-28 22:23:23', '2025-01-29 09:15:27', NULL),
(7, 1, 'Cig Chicken Planet', 'O sabor irresistível a frango.', 'Hambúrgueres', 8.00, 1, 0.00, 1000, 100, 'rest_00001_20250129_091538_burger_08.png', '2025-01-28 22:23:23', '2025-01-29 09:15:38', NULL),
(8, 1, 'Cig Vegan World', 'Para quem ama vegetais.', 'Hambúrgueres', 10.70, 1, 0.00, 1000, 100, 'rest_00001_20250129_091549_burger_09.png', '2025-01-28 22:23:23', '2025-01-29 09:15:49', NULL),
(9, 1, 'Cig Chicken Barbecue', 'Frango com sabor a churrasco.', 'Hambúrgueres', 8.80, 1, 0.00, 1000, 100, 'rest_00001_20250129_091601_burger_10.png', '2025-01-28 22:23:23', '2025-01-29 09:16:01', NULL),
(10, 1, 'Cig Fish & Sea', 'O mar dentro do um hambúrguer.', 'Hambúrgueres', 9.70, 1, 0.00, 1000, 100, 'rest_00001_20250129_091619_burger_11.png', '2025-01-28 22:23:23', '2025-01-29 09:16:19', NULL),
(11, 1, 'Cig Fish & Vegs', 'O sabor do mar e dos vegetais.', 'Hambúrgueres', 10.50, 1, 0.00, 1000, 100, 'rest_00001_20250129_091731_burger_12.png', '2025-01-28 22:23:23', '2025-01-29 09:17:31', NULL),
(12, 1, 'Cig Master Crusher', 'Para quem não gosta de um simples hambúrguer convencional.', 'Hambúrgueres', 15.00, 1, 0.00, 1000, 100, 'rest_00001_20250129_091635_burger_12.png', '2025-01-28 22:23:23', '2025-01-29 09:16:35', NULL),
(13, 1, 'Batatas fritas', 'O melhor acompanhamento para um hambúrguer.', 'Acompanhamentos', 2.00, 1, 0.00, 1000, 100, 'rest_00001_20250129_091701_french_fries.png', '2025-01-28 22:23:23', '2025-01-29 09:17:01', NULL),
(14, 1, 'Café', 'O sabor do bom café.', 'Bebidas', 1.50, 1, 0.00, 1000, 100, 'rest_00001_20250129_091712_caffee.png', '2025-01-28 22:23:23', '2025-01-29 09:17:12', NULL),
(15, 1, 'Cig Coca', 'Bebida refrescante.', 'Bebidas', 3.50, 1, 0.00, 1000, 100, 'rest_00001_20250129_091818_drink_03.png', '2025-01-28 22:23:23', '2025-01-29 09:18:18', NULL),
(16, 1, 'Cig Fanta', 'Bebida refrescante com sabor a laranja.', 'Bebidas', 3.50, 1, 0.00, 1000, 100, 'rest_00001_20250129_091832_drink_01.png', '2025-01-28 22:23:23', '2025-01-29 09:18:32', NULL),
(17, 1, 'Cig Ice Tea', 'Vai um chá frio?', 'Bebidas', 3.50, 1, 0.00, 1000, 100, 'rest_00001_20250129_091905_caffee.png', '2025-01-28 22:23:23', '2025-01-29 09:19:05', NULL),
(18, 1, 'Cig Caramelo Ice', 'Gelado com topping de caramelo.', 'Sobremesas', 3.00, 1, 0.00, 1000, 100, 'rest_00001_20250129_091930_ice_cream_01.png', '2025-01-28 22:23:23', '2025-01-29 09:19:30', NULL),
(19, 1, 'Cig Chocolate Ice', 'Gelado com topping de chocolate.', 'Sobremesas', 3.00, 1, 0.00, 1000, 100, 'rest_00001_20250129_091945_ice_cream_02.png', '2025-01-28 22:23:23', '2025-01-29 09:19:45', NULL),
(20, 1, 'Cig Strawberry Ice', 'Gelado com topping de morango.', 'Sobremesas', 3.00, 1, 0.00, 1000, 100, 'rest_00001_20250129_092009_ice_cream_03.png', '2025-01-28 22:23:23', '2025-01-29 09:20:09', NULL),
(21, 1, 'Cig Ketchup', 'Acompanhamento tradicional.', 'Acompanhamentos', 1.00, 1, 0.00, 1000, 100, 'rest_00001_20250129_092207_ketchup.png', '2025-01-28 22:23:23', '2025-01-29 09:22:07', NULL),
(22, 1, 'Cig Mustarda', 'Acompanhamento tradicional.', 'Acompanhamentos', 1.00, 1, 0.00, 1000, 100, 'rest_00001_20250129_092150_mustard.png', '2025-01-28 22:23:23', '2025-01-29 09:21:50', NULL),
(23, 1, 'Cig Nuggets', 'Sabor do frango em pequenos pedaços.', 'Acompanhamentos', 4.00, 1, 0.00, 1000, 100, 'rest_00001_20250129_092221_nuggets_01.png', '2025-01-28 22:23:23', '2025-01-29 09:22:21', NULL),
(24, 1, 'Cig Nuggets Box', 'Sabor do frango em 10 pequenos pedaços.', 'Acompanhamentos', 8.00, 1, 0.00, 1000, 100, 'rest_00001_20250129_092234_nuggets_02.png', '2025-01-28 22:23:23', '2025-01-29 09:22:34', NULL),
(25, 2, 'Cig Hamburger', 'O melhor hambúrguer pelo melhor preço.', 'Hambúrgueres', 6.50, 1, 0.00, 31000, 100, 'rest_00002_20250213_112029_burger_01.png', '2025-02-13 11:18:55', '2025-02-13 19:18:50', NULL),
(26, 2, 'Cig Cheese In', 'O sabor do queijo dentro do hambúrguer.', 'Hambúrgueres', 8.00, 1, 0.00, 1000, 100, 'rest_00002_20250213_112103_burger_02.png', '2025-02-13 11:18:55', '2025-02-13 11:21:03', NULL),
(27, 2, 'Cig Double', 'Duas vezes mais sabor.', 'Hambúrgueres', 12.50, 1, 0.00, 1000, 100, 'rest_00002_20250213_114032_burger_03.png', '2025-02-13 11:18:55', '2025-02-13 11:40:32', NULL),
(28, 2, 'Cig Double Cheese', 'Duas vezes mais queijo e mais sabor.', 'Hambúrgueres', 13.20, 1, 0.00, 1000, 100, 'rest_00002_20250213_114043_burger_05.png', '2025-02-13 11:18:55', '2025-02-13 11:40:43', NULL),
(29, 2, 'Cig Bacon Strike', 'Um hambúrguer com bacon estaladiço.', 'Hambúrgueres', 11.50, 1, 0.00, 1000, 100, 'rest_00002_20250213_114055_burger_06.png', '2025-02-13 11:18:55', '2025-02-13 11:40:55', NULL),
(30, 2, 'Cig Royale', 'Uma hambúrguer ao estilo casa real.', 'Hambúrgueres', 13.00, 1, 0.00, 1000, 100, 'rest_00002_20250213_114105_burger_07.png', '2025-02-13 11:18:55', '2025-02-13 11:41:05', NULL),
(31, 2, 'Cig Chicken Planet', 'O sabor irresistível a frango.', 'Hambúrgueres', 8.00, 1, 0.00, 1000, 100, 'rest_00002_20250213_114122_burger_07.png', '2025-02-13 11:18:55', '2025-02-13 11:41:22', NULL),
(32, 2, 'Cig Vegan World', 'Para quem ama vegetais.', 'Hambúrgueres', 10.70, 1, 0.00, 1000, 100, 'rest_00002_20250213_114137_burger_08.png', '2025-02-13 11:18:55', '2025-02-13 11:41:37', NULL),
(33, 2, 'Cig Chicken Barbecue', 'Frango com sabor a churrasco.', 'Hambúrgueres', 8.80, 1, 0.00, 1000, 100, 'rest_00002_20250213_114157_burger_10.png', '2025-02-13 11:18:55', '2025-02-13 11:41:57', NULL),
(34, 2, 'Cig Fish & Sea', 'O mar dentro do um hambúrguer.', 'Hambúrgueres', 9.70, 1, 0.00, 1000, 100, 'rest_00002_20250213_114207_burger_11.png', '2025-02-13 11:18:55', '2025-02-13 11:42:07', NULL),
(35, 2, 'Cig Fish & Vegs', 'O sabor do mar e dos vegetais.', 'Hambúrgueres', 10.50, 1, 0.00, 1000, 100, 'rest_00002_20250213_114248_burger_12.png', '2025-02-13 11:18:55', '2025-02-13 11:42:48', NULL),
(36, 2, 'Cig Master Crusher', 'Para quem não gosta de um simples hambúrguer convencional.', 'Hambúrgueres', 15.00, 1, 0.00, 1000, 100, 'rest_00002_20250213_114307_burger_12.png', '2025-02-13 11:18:55', '2025-02-13 11:43:07', NULL),
(37, 2, 'Batatas fritas', 'O melhor acompanhamento para um hambúrguer.', 'Acompanhamentos', 2.00, 1, 0.00, 1000, 100, 'rest_00002_20250213_114322_french_fries.png', '2025-02-13 11:18:55', '2025-02-13 11:43:22', NULL),
(38, 2, 'Café', 'O sabor do bom café.', 'Bebidas', 1.50, 1, 0.00, 1000, 100, 'rest_00002_20250213_114353_caffee.png', '2025-02-13 11:18:55', '2025-02-13 11:43:53', NULL),
(39, 2, 'Cig Coca', 'Bebida refrescante.', 'Bebidas', 3.50, 1, 0.00, 1000, 100, 'rest_00002_20250213_114413_drink_02.png', '2025-02-13 11:18:55', '2025-02-13 11:44:13', NULL),
(40, 2, 'Cig Fanta', 'Bebida refrescante com sabor a laranja.', 'Bebidas', 3.50, 1, 0.00, 1000, 100, 'rest_00002_20250213_190934_drink_02.png', '2025-02-13 11:18:55', '2025-02-13 19:09:34', NULL),
(41, 2, 'Cig Ice Tea', 'Vai um chá frio?', 'Bebidas', 3.50, 1, 0.00, 1000, 100, 'rest_00002_20250213_191020_caffee.png', '2025-02-13 11:18:55', '2025-02-13 19:10:20', NULL),
(42, 2, 'Cig Caramelo Ice', 'Gelado com topping de caramelo.', 'Sobremesas', 3.00, 1, 0.00, 1000, 100, 'rest_00002_20250213_190959_ice_cream_03.png', '2025-02-13 11:18:55', '2025-02-13 19:09:59', NULL),
(43, 2, 'Cig Chocolate Ice', 'Gelado com topping de chocolate.', 'Sobremesas', 3.00, 1, 0.00, 1000, 100, 'rest_00002_20250213_191045_ice_cream_03.png', '2025-02-13 11:18:55', '2025-02-13 19:10:45', NULL),
(44, 2, 'Cig Strawberry Ice', 'Gelado com topping de morango.', 'Sobremesas', 3.00, 1, 0.00, 1000, 100, 'rest_00002_20250213_191104_ice_cream_02.png', '2025-02-13 11:18:55', '2025-02-13 19:11:04', NULL),
(45, 2, 'Cig Ketchup', 'Acompanhamento tradicional.', 'Acompanhamentos', 1.00, 1, 0.00, 1000, 100, 'rest_00002_20250213_191121_ketchup.png', '2025-02-13 11:18:55', '2025-02-13 19:11:21', NULL),
(46, 2, 'Cig Mustarda', 'Acompanhamento tradicional.', 'Acompanhamentos', 1.00, 1, 0.00, 1000, 100, 'rest_00002_20250213_191201_mustard.png', '2025-02-13 11:18:55', '2025-02-13 19:12:01', NULL),
(47, 2, 'Cig Nuggets', 'Sabor do frango em pequenos pedaços.', 'Acompanhamentos', 4.00, 1, 0.00, 1000, 100, 'rest_00002_20250213_191144_nuggets_01.png', '2025-02-13 11:18:55', '2025-02-13 19:11:44', NULL),
(48, 2, 'Cig Nuggets Box', 'Sabor do frango em 10 pequenos pedaços.', 'Acompanhamentos', 8.00, 1, 0.00, 1000, 100, 'rest_00002_20250213_191216_nuggets_02.png', '2025-02-13 11:18:55', '2025-02-13 19:12:16', NULL),
(49, 1, 'Cig Nuggets Box 1', 'O melhor hamburguer da Historia', 'Hamburgueres', 19.90, 1, 10.00, 20000, 1000, 'rest_00001_20250527_190136_burger_10.png', '2025-05-27 19:01:36', '2025-05-27 19:01:36', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `restaurants`
--

CREATE TABLE `restaurants` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `project_id` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `api_key` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `address`, `phone`, `email`, `project_id`, `api_key`, `created_at`, `update_at`, `deleted_at`) VALUES
(1, 'Restaurante 1', 'Rua ABC, cidade ABC', '+55 (34)-123456', 'restaurante1@email.com', '10000', '$2y$10$AsdZcMmkZ5QIGIlBThleoO7cbmYc.wlP4DqQQPZB2N/5BGU./.ZTq', '2025-01-28 22:22:23', NULL, NULL),
(2, 'Restaurante 2', 'Rua ABC, cidade ABC', '+55 (34)-123456', 'restaurante2@email.com', '20000', '$2y$10$Wq5fk8HDOzIYLDIQz5fCzOz1PbbW.46wM4i.nmZiOVcRb950Pxy.S', '2025-01-28 22:22:23', '2025-02-13 23:23:25', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `stocks`
--

CREATE TABLE `stocks` (
  `id` int UNSIGNED NOT NULL,
  `id_product` int NOT NULL,
  `stock_quantity` int NOT NULL,
  `stock_in_out` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stock_supplier` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reason` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `moviment_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `stocks`
--

INSERT INTO `stocks` (`id`, `id_product`, `stock_quantity`, `stock_in_out`, `stock_supplier`, `reason`, `moviment_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 13, 1000, 'IN', 'CafeeTop', '', '2025-01-30 20:42:18', '2025-01-30 20:42:18', NULL, NULL),
(2, 14, 1000, 'IN', 'Coca Cola', '', '2025-01-30 20:42:18', '2025-01-30 20:42:18', NULL, NULL),
(3, 13, 1000, 'IN', 'CafeeTop', '', '2025-01-30 20:42:18', '2025-01-30 20:42:18', NULL, NULL),
(4, 14, 1000, 'IN', 'Coca Cola', '', '2025-01-30 20:42:18', '2025-01-30 20:42:18', NULL, NULL),
(5, 13, 800, 'IN', 'Desconhecido', '', '2025-01-30 20:42:18', '2025-01-30 20:42:18', NULL, NULL),
(6, 100, 2000, 'IN', 'Starbucks', '', '2025-01-30 20:42:18', '2025-01-30 20:42:18', NULL, NULL),
(7, 1, 20, 'OUT', 'Owner', 'Out of date', '2025-01-30 20:42:18', '2025-01-30 20:42:18', NULL, NULL),
(8, 1, 5, 'OUT', 'Owner', 'Out of date', '2025-01-30 20:42:18', '2025-01-30 20:42:18', NULL, NULL),
(9, 1, 151, 'IN', 'Desconhecido', 'Americanas', NULL, '2025-01-30 22:53:00', '2025-01-30 21:53:21', NULL),
(10, 2, 5030, 'IN', 'CafeeTop', '', NULL, '2025-01-31 18:00:00', '2025-01-31 17:22:10', NULL),
(11, 2, 500, 'OUT', 'Owner', '', NULL, '2025-01-31 17:37:06', '2025-01-31 17:37:06', NULL),
(12, 2, 100, 'OUT', 'Owner', 'Produtos expirados', '2025-01-31 00:00:00', '2025-01-31 17:47:00', '2025-01-31 17:47:00', NULL),
(13, 4, 8000, 'IN', 'Desconhecido', '', '2025-02-01 00:00:00', '2025-02-01 19:12:26', '2025-02-01 19:12:26', NULL),
(14, 4, 5000, 'OUT', 'Owner', 'Produtos expirados', '2025-02-01 00:20:00', '2025-02-01 19:13:37', '2025-02-01 19:13:37', NULL),
(15, 2, 30, 'OUT', 'Owner', '', '2025-02-02 00:00:00', '2025-02-02 19:58:45', '2025-02-02 19:58:45', NULL),
(16, 1, 20, 'IN', 'Coca Cola', '', '2025-02-06 12:00:00', '2025-02-05 23:06:22', '2025-02-05 23:06:22', NULL),
(17, 1, 171, 'OUT', 'Owner', 'Danificados', '2025-02-07 14:07:00', '2025-02-07 13:08:08', '2025-02-07 13:08:08', NULL),
(18, 25, 30000, 'IN', 'Desconhecido', '', '2025-02-13 07:00:00', '2025-02-13 19:18:50', '2025-02-13 19:18:50', NULL),
(19, 1, 1000, 'IN', 'CafeeTop', 'Produtos expirados', '2025-05-22 00:00:00', '2025-05-27 19:00:19', '2025-05-27 19:00:19', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL COMMENT 'Primary Key',
  `id_restaurant` int UNSIGNED NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `passwrd` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `roles` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `blocked_until` datetime DEFAULT NULL,
  `is_active` int DEFAULT NULL,
  `code` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `id_restaurant`, `first_name`, `last_name`, `full_name`, `username`, `email`, `phone`, `passwrd`, `roles`, `blocked_until`, `is_active`, `code`, `last_login`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Administrador', 'Restaurante 1', 'Aministrador Restaurante 1', 'admin1', 'admin1@email.com', '9290323339', '$2y$10$JAPRWWPddRPsXe9BK91ige64fFPY5XmqEW4C2ImLkGqH3Ic8mfeA2', '[\"admin\"]', NULL, 1, '3a26d819eb34896e52487e8869f0000b', '2025-06-24 11:44:27', '2025-01-28 22:21:51', '2025-06-24 11:44:27', NULL),
(2, 2, 'Administrador', 'Restaurante 2', 'Aministrador Restaurante 2', 'admin2', 'admin2@email.com', '987654321', '$2y$10$iwM/MpPACiuNRoRuhiaIzOG/3e3dkCGdaczuNMBl9oGMgzOFPqH16', '[\"admin\"]', NULL, 1, NULL, '2025-02-13 17:43:17', '2025-01-28 22:21:51', '2025-02-13 17:43:17', NULL),
(4, 1, 'User 1', 'Restaurante 1', 'Aministrador Restaurante 2', 'user1', 'user1@email.com', '123056489', '$2y$10$e8Qy48OQTmYJMBySbvby2O5sAcuK1oAn/dSol8zkdpS9jBqwk4/.e', '[\"user\"]', NULL, 1, NULL, '2025-06-02 19:39:30', '2025-01-28 22:21:52', '2025-06-02 19:39:30', NULL),
(5, 2, 'User 2', 'Restaurante 2', 'Aministrador Restaurante 2', 'user2', 'user2@email.com', '103056789', '$2y$10$DFlw.4fVRRBAjiDmsc5ZMuaYj7CXyPxnRMwg/IbpwJ5IBBu.JBMq6', '[\"user\"]', '2025-05-28 22:10:35', 1, NULL, '2025-02-13 19:17:42', '2025-01-28 22:21:52', '2025-02-13 19:17:42', NULL),
(14, 1, 'User Test', 'User Test', 'User Test User Test', 'User Test', 'user.test@email.com', '987654322', '', '[\"user\"]', '2025-05-31 23:59:59', 1, '496b22793e8d218cd31f06f6f7d04fcd', NULL, '2025-05-30 20:42:22', '2025-06-02 02:50:57', NULL),
(15, 1, 'kskjddjks', 'sd', 'kskjddjks sd', 'User Test1', 'user2.test@email.com', '9293892920', '', '[\"admin\"]', NULL, 1, '74624e01a943a442dbf164737b626fcb', NULL, '2025-05-30 20:43:28', '2025-06-01 00:24:28', NULL),
(16, 1, 'Novo ', 'usuario 1', 'Novo  usuario 1', 'novo_usuario1', 'novo.usuario1@email.com', '9876543212', '', '[\"admin\"]', NULL, 0, '3571bf687a8c66df897ef09c88139543', NULL, '2025-05-31 00:26:54', NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de tabela `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary Key', AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
