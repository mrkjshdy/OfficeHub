-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2026 at 05:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `officehub_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `activity`, `created_at`) VALUES
(1, 1, 'Added product: Test chair', '2026-07-18 13:31:27'),
(2, 1, 'Edited product: Test chair', '2026-07-18 13:35:27'),
(3, 1, 'Deleted product: Test chair', '2026-07-18 13:36:28');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `created_at`) VALUES
(1, 'Office Chairs', '2026-07-18 09:09:05'),
(2, 'Office Tables', '2026-07-18 09:09:05'),
(3, 'Office Cabinets', '2026-07-18 09:09:05'),
(4, 'Office Accessories', '2026-07-18 09:09:05'),
(5, 'Meeting Room Equipment', '2026-07-18 09:09:05');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('Pending','Paid','Completed','Cancelled') DEFAULT 'Pending',
  `payment_method` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `status`, `payment_method`, `created_at`) VALUES
(1, 2, 16998.00, 'Pending', 'Cash on Delivery', '2026-07-18 13:50:23');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `subtotal`) VALUES
(1, 1, 2, 2, 8499.00, 16998.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `product_name`, `description`, `price`, `stock`, `image`, `created_at`) VALUES
(1, 1, 'AeroFlex Pro Ergonomic Chair', 'Modern ergonomic office chair with breathable mesh backrest, adjustable headrest, and lumbar support designed for all-day comfort.', 5499.00, 15, 'aeroflex-pro-ergonomic-chair.jpg', '2026-07-18 10:03:31'),
(2, 1, 'Vertex Elite Ergonomic Chair', 'Premium ergonomic chair featuring a multi-adjustable headrest, dynamic lumbar support, reclining mechanism, and high-density mesh seating.', 8499.00, 10, 'vertex-elite-ergonomic-chair.jpg', '2026-07-18 10:03:31'),
(3, 1, 'NovaMesh Office Chair', 'Lightweight mesh office chair with adjustable height, ergonomic back support, and smooth-rolling caster wheels for everyday office use.', 4999.00, 20, 'novamesh-office-chair.jpg', '2026-07-18 10:03:31'),
(4, 2, 'Titan Work Desk', 'A contemporary office work desk featuring a durable woodgrain finish, integrated mobile pedestal cabinet, and a spacious work surface designed for everyday office productivity.', 6499.00, 15, 'titan-work-desk.jpg', '2026-07-18 10:13:14'),
(5, 2, 'Elevate Standing Desk', 'An electric height-adjustable standing desk with a minimalist design, programmable height controls, and a sturdy steel frame for enhanced comfort and workplace ergonomics.', 13999.00, 10, 'elevate-standing-desk.jpg', '2026-07-18 10:13:14'),
(6, 2, 'Horizon Executive Desk', 'A premium executive office desk featuring built-in storage drawers, cable management ports, and a spacious work surface that complements modern professional workspaces.', 11999.00, 12, 'horizon-executive-desk.jpg', '2026-07-18 10:13:14'),
(7, 3, 'FlexStore Mobile Pedestal Cabinet', 'A compact mobile pedestal cabinet featuring smooth-rolling caster wheels, multiple storage compartments, and a durable woodgrain finish for organized office workspaces.', 4299.00, 18, 'flexstore-mobile-pedestal-cabinet.jpg', '2026-07-18 10:23:42'),
(8, 3, 'SteelGuard 3-Drawer Filing Cabinet', 'A modern three-drawer filing cabinet designed with spacious storage, durable construction, and smooth-glide drawers to keep office documents organized.', 5499.00, 12, 'steelguard-3-drawer-filing-cabinet.jpg', '2026-07-18 10:23:42'),
(9, 3, 'SecureFile Lateral Filing Cabinet', 'A premium lateral filing cabinet with two spacious drawers, lockable storage, and a minimalist design ideal for professional office environments.', 6299.00, 8, 'securefile-lateral-filing-cabinet.jpg', '2026-07-18 10:23:42'),
(10, 4, 'Glide Wireless Mouse', 'A lightweight wireless optical mouse featuring precise tracking, ergonomic comfort, and long-lasting battery life for everyday office productivity.', 899.00, 30, 'glide-wireless-mouse.jpg', '2026-07-18 10:30:39'),
(11, 4, 'Vision Wood Monitor Stand', 'A durable wooden monitor stand that elevates your display to an ergonomic viewing height while providing additional desk organization and workspace efficiency.', 1299.00, 18, 'vision-wood-monitor-stand.jpg', '2026-07-18 10:30:39'),
(12, 4, 'Precision Wired Keyboard', 'A full-size wired keyboard with responsive low-profile keys, a numeric keypad, and a durable design built for reliable office use.', 1499.00, 25, 'precision-wired-keyboard.jpg', '2026-07-18 10:30:39'),
(13, 5, 'Vision Projection Screen', 'A premium pull-down projection screen with a smooth matte viewing surface, delivering sharp visuals for presentations, training sessions, and business meetings.', 5499.00, 10, 'vision-projection-screen.jpg', '2026-07-18 10:38:21'),
(14, 5, 'SmartWrite Mobile Whiteboard', 'A double-sided magnetic whiteboard with a sturdy rolling frame, providing a flexible solution for brainstorming sessions, presentations, and collaborative meetings.', 4299.00, 8, 'smartwrite-mobile-whiteboard.jpg', '2026-07-18 10:38:21'),
(15, 5, 'Summit Conference Table', 'A premium conference table with an integrated cable management system and a spacious tabletop, designed to accommodate productive team meetings and executive discussions.', 17999.00, 5, 'summit-conference-table.jpg', '2026-07-18 10:38:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `role` enum('admin','buyer') DEFAULT 'buyer',
  `is_verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `address`, `contact_number`, `role`, `is_verified`, `created_at`) VALUES
(1, 'Mark Dayao', 'feu@edu.ph', '$2y$10$pQOuHHDxam9vm69277n3Y.h6Q6KcZD7OnArGorlLIDI8m1.PiBBZu', 'Blk 67 lot 67, Quezon City', '09676767677', 'admin', 0, '2026-07-18 11:32:44'),
(2, 'Megan Fox', 'fox@edu.ph', '$2y$10$9Y.FhWbVRujz.NhTIzZtROEZKhXEO.lonoPNXTFFmu3m5g5Xe1LJG', 'West ave. Binondo', '09654654567', 'buyer', 0, '2026-07-18 11:45:59');

-- --------------------------------------------------------

--
-- Table structure for table `verification_tokens`
--

CREATE TABLE `verification_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_audit_user` (`user_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cart_user` (`user_id`),
  ADD KEY `fk_cart_product` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_user` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orderitems_order` (`order_id`),
  ADD KEY `fk_orderitems_product` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_category` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `verification_tokens`
--
ALTER TABLE `verification_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_verify_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `verification_tokens`
--
ALTER TABLE `verification_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `fk_audit_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_order_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_orderitems_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orderitems_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `verification_tokens`
--
ALTER TABLE `verification_tokens`
  ADD CONSTRAINT `fk_verify_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
