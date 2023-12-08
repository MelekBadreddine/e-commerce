-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 03 déc. 2023 à 15:41
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `shop_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
(1, 'admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2');

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `pid` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int NOT NULL,
  `quantity` int NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `code` int NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=801 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`code`, `name`) VALUES
(1, 'laptop'),
(2, 'tv'),
(3, 'camera'),
(4, 'mouse'),
(5, 'fridge'),
(6, 'washing machine'),
(7, 'smartphone'),
(8, 'watch');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(1, 0, 'Melek', 'melek@enis.tn', '544545554', 'shitty products'),
(2, 0, 'Melek', 'melek@enis.tn', '5454554544', 'shit'),
(3, 0, 'Yassine', 'yassine@enis.tn', '51265487', 'fuck'),
(4, 0, 'ali', 'ali@enis.tn', '5445847', 'yetkalam');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int NOT NULL,
  `placed_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(1, 2, 'melek', '123', 'mbadreddine5@gmail.com', 'credit card', 'flat no. Rte Teboulbi km 4, steyey, Sfax, djzddy, Tunisie - 3041', 'Wireless Mouse (30 x 1) - ', 30, '2023-11-27 20:49:05', 'completed'),
(2, 2, 'Melek Badreddine', '54459691', 'melek@enis.tn', 'cash on delivery', 'flat no. Rte Teboulbi km 4, steyey, Sfax, djzddy, Tunisie - 3041', 'Wireless Mouse (30 x 1) - ', 30, '2023-11-30 14:23:37', 'pending'),
(3, 2, '', '', '', '', '', '', 0, '2023-11-30 20:33:31', 'pending'),
(10, 2, 'Melek Badreddine', '54459691', 'melek@enis.tn', 'cash on delivery', 'flat no. Rte Teboulbi km 4, steyey, Sfax, djzddy, Tunisie - 3041', 'Wireless Mouse ($30 x 1) - ', 30, '2023-11-30 21:17:02', 'pending');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int NOT NULL,
  `image_01` varchar(100) NOT NULL,
  `image_02` varchar(100) NOT NULL,
  `image_03` varchar(100) NOT NULL,
  `code_category` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_category` (`code_category`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `price`, `image_01`, `image_02`, `image_03`, `code_category`) VALUES
(38, 'Front-Load Washing Machine', 'Energy-efficient front-load washing machine with multiple wash cycles', 1200, 'assets/images/products/washing machine-1.webp', 'assets/images/products/washing machine-2.webp', 'assets/images/products/washing machine-3.webp', 6),
(39, 'Wireless Mouse', 'Ergonomic wireless mouse for precise and comfortable navigation', 30, 'assets/images/products/mouse-1.webp', 'assets/images/products/mouse-2.webp', 'assets/images/products/mouse-3.webp', 4),
(40, 'Classic Wristwatch', 'Elegant classic wristwatch with a leather strap', 150, 'assets/images/products/watch-1.webp', 'assets/images/products/watch-2.webp', 'assets/images/products/watch-3.webp', 8),
(41, 'Smartphone', 'Latest smartphone with high-resolution camera and AI capabilities', 800, 'assets/images/products/smartphone-1.webp', 'assets/images/products/smartphone-2.webp', 'assets/images/products/smartphone-3.webp', 7),
(42, 'Camera', 'High-resolution camera for professional photography', 900, 'assets/images/products/camera-1.webp', 'assets/images/products/camera-2.webp', 'assets/images/products/camera-3.webp', 3),
(43, 'Laptop', 'Powerful and portable laptop for multitasking', 1100, 'assets/images/products/laptop-1.webp', 'assets/images/products/laptop-2.webp', 'assets/images/products/laptop-3.webp', 1),
(44, 'Fridge', 'Energy-efficient refrigerator with ample storage', 1400, 'assets/images/products/fridge-1.webp', 'assets/images/products/fridge-2.webp', 'assets/images/products/fridge-3.webp', 5),
(45, 'TV', 'High-definition television for immersive viewing experience', 1000, 'assets/images/products/tv-01.webp', 'assets/images/products/tv-02.webp', 'assets/images/products/tv-03.webp', 2),
(46, 'Gaming Laptop', 'High-performance gaming laptop with dedicated graphics', 1500, 'assets/images/products/gaming-laptop-1.webp', 'assets/images/products/gaming-laptop-2.webp', 'assets/images/products/gaming-laptop-3.webp', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'melek', 'melek@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(2, 'yassine', 'yassine@enis.tn', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');

-- --------------------------------------------------------

--
-- Structure de la table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE IF NOT EXISTS `wishlist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `pid` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`code_category`) REFERENCES `category` (`code`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
