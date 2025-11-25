-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Nov 2025 pada 17.33
-- Versi server: 10.1.37-MariaDB
-- Versi PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_sales_order`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `audit_log`
--

CREATE TABLE `audit_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `action` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `audit_log`
--

INSERT INTO `audit_log` (`id`, `user_id`, `action`, `detail`, `created_at`) VALUES
(1, 2, 'logout', 'User logout.', '2025-11-22 10:41:56'),
(2, 7, 'login', 'User Manager Utama berhasil login.', '2025-11-22 10:42:01'),
(3, 7, 'logout', 'User logout.', '2025-11-22 10:42:10'),
(4, 5, 'login', 'User Rahayu Sales berhasil login.', '2025-11-22 10:42:16'),
(5, 5, 'create', 'Membuat sales order: SO005', '2025-11-22 10:43:58'),
(6, 5, 'logout', 'User logout.', '2025-11-22 10:44:17'),
(7, 2, 'login', 'User Administrator berhasil login.', '2025-11-22 10:44:23'),
(8, 2, 'update', 'Mengubah produk ID 7 menjadi: Mesin Cuci Aqua 2 Tabung', '2025-11-22 11:02:48'),
(9, 2, 'logout', 'User logout.', '2025-11-22 11:04:14'),
(10, 7, 'login', 'User Manager Utama berhasil login.', '2025-11-22 11:04:19'),
(11, 7, 'logout', 'User logout.', '2025-11-22 12:31:53'),
(12, 5, 'login', 'User Rahayu Sales berhasil login.', '2025-11-22 12:32:43'),
(13, 5, 'create', 'Membuat sales order: SO006', '2025-11-22 12:33:56'),
(14, 5, 'logout', 'User logout.', '2025-11-22 12:34:13'),
(15, 2, 'login', 'User Administrator berhasil login.', '2025-11-22 12:34:23'),
(16, 2, 'update', 'Mengubah produk ID 3 menjadi: Kulkas Dua Pintu', '2025-11-22 12:34:47'),
(17, 2, 'update', 'Mengubah produk ID 3 menjadi: Kulkas Dua Pintu', '2025-11-22 12:35:02'),
(18, 2, 'update', 'Update data sales ID 1', '2025-11-22 12:36:05'),
(19, 2, 'update', 'Update data sales ID 1', '2025-11-22 12:36:33'),
(20, 2, 'delete', 'Menghapus sales ID 7', '2025-11-22 12:36:40'),
(21, 2, 'update', 'Update data sales ID 1', '2025-11-22 12:37:11'),
(22, 2, 'create', 'Menambahkan sales: ', '2025-11-22 12:37:41'),
(23, 2, 'delete', 'Menghapus sales ID 8', '2025-11-22 12:37:49'),
(24, 2, 'update', 'Mengubah status order SO006 menjadi: dikirim', '2025-11-22 12:38:12'),
(25, 2, 'logout', 'User logout.', '2025-11-22 12:43:22'),
(26, 7, 'login', 'User Manager Utama berhasil login.', '2025-11-22 12:43:28'),
(27, 7, 'logout', 'User logout.', '2025-11-22 12:44:37'),
(28, 5, 'login', 'User Rahayu Sales berhasil login.', '2025-11-22 12:44:43'),
(29, 5, 'create', 'Membuat sales order: SO007', '2025-11-22 12:45:10'),
(30, 5, 'logout', 'User logout.', '2025-11-22 12:45:16'),
(31, 2, 'login', 'User Administrator berhasil login.', '2025-11-22 12:45:22'),
(32, 2, 'login', 'User Administrator berhasil login.', '2025-11-22 17:06:23'),
(33, 2, 'create', 'Menambahkan produk baru: Smartphone Oppo A37', '2025-11-22 17:08:03'),
(34, 2, 'logout', 'User logout.', '2025-11-22 17:10:43'),
(35, 7, 'login', 'User Manager Utama berhasil login.', '2025-11-22 17:10:48'),
(36, 7, 'logout', 'User logout.', '2025-11-22 17:11:20'),
(37, 5, 'login', 'User Rahayu Sales berhasil login.', '2025-11-22 17:11:26'),
(38, 5, 'logout', 'User logout.', '2025-11-22 17:11:56'),
(39, 2, 'login', 'User Administrator berhasil login.', '2025-11-24 20:06:42'),
(40, 2, 'update', 'Mengubah produk ID 5 menjadi: Asus ROG', '2025-11-24 20:07:17'),
(41, 2, 'update', 'Mengubah produk ID 5 menjadi: Asus ROG', '2025-11-24 20:07:28'),
(42, 2, 'logout', 'User logout.', '2025-11-24 20:09:45'),
(43, 7, 'login', 'User Manager Utama berhasil login.', '2025-11-24 20:09:51'),
(44, 7, 'logout', 'User logout.', '2025-11-24 20:10:19'),
(45, 2, 'login', 'User Administrator berhasil login.', '2025-11-24 20:10:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `customers`
--

INSERT INTO `customers` (`id`, `customer_code`, `name`, `address`, `phone`, `email`, `created_at`) VALUES
(4, 'CUST001', 'PT Partner Jaya', 'Jl. Malioboro No.21 Yogyakarta', '022-700000', 'Partner.jaya@mail.com', '2025-10-26 15:34:58'),
(5, 'CUST003', 'Toko Elektronik Sugiharto', 'Jl. Wonosari - Yogyakarta No.16 GunungKidul', '022-600000', 'Eelektro.Sugiharto@mail.com', '2025-10-26 15:34:58'),
(6, 'CUST002', 'Toko Elektronik Makmur', 'Jl. Sudirman No.12 Jakarta', '021-800000', 'Elektronik.makmur@mail.com', '2025-10-26 15:34:58'),
(7, 'CUST004', 'PT Gemilang Sejahtera', 'Jl NotoKusumo No.68, Yogyakarta', '021-233445', 'GemilangSejahtera@mail.com', '2025-11-16 02:23:09'),
(8, 'CUST005', 'PT Sejahtera Abadi', 'Jl Kaliurang Km.31 No.16, Yogyakarta', '021-34567890', 'Sejahtera.abadi@mail.com', '2025-11-22 03:55:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `sales_id` int(10) UNSIGNED NOT NULL,
  `status` enum('draft','dikirim','selesai','dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `total_price` decimal(14,2) NOT NULL DEFAULT '0.00',
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `sent_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `canceled_at` datetime DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `order_code`, `customer_id`, `sales_id`, `status`, `total_price`, `order_date`, `sent_at`, `completed_at`, `canceled_at`, `note`) VALUES
(1, 'SO001', 5, 1, 'dikirim', '62600000.00', '2025-11-16 01:26:05', '2025-11-22 09:42:26', NULL, NULL, ''),
(4, 'SO002', 5, 5, 'selesai', '57400000.00', '2025-11-16 02:19:35', NULL, '2025-11-22 02:55:01', NULL, 'Alat Elektronik Rumah Tangga'),
(9, 'SO003', 6, 6, 'dibatalkan', '100000000.00', '2025-11-22 02:55:47', NULL, NULL, '2025-11-22 02:56:16', 'Laptop Gaming'),
(16, 'SO004', 4, 6, 'dibatalkan', '250000000.00', '2025-11-22 03:45:33', NULL, NULL, '2025-11-22 03:46:22', ''),
(18, 'SO005', 5, 5, 'draft', '79000000.00', '2025-11-22 10:43:58', NULL, NULL, NULL, ''),
(19, 'SO006', 8, 5, 'dikirim', '101000000.00', '2025-11-22 12:33:56', '2025-11-22 12:38:12', NULL, NULL, 'Pembelian Laptop'),
(20, 'SO007', 7, 5, 'draft', '10500000.00', '2025-11-22 12:45:10', NULL, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `unit_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `subtotal` decimal(14,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`, `subtotal`) VALUES
(1, 1, 5, 2, '25000000.00', '50000000.00'),
(2, 1, 3, 3, '4200000.00', '12600000.00'),
(3, 4, 3, 7, '4200000.00', '29400000.00'),
(4, 4, 2, 8, '3500000.00', '28000000.00'),
(9, 9, 5, 4, '25000000.00', '100000000.00'),
(18, 16, 5, 10, '25000000.00', '250000000.00'),
(24, 18, 7, 3, '24000000.00', '72000000.00'),
(25, 18, 2, 2, '3500000.00', '7000000.00'),
(26, 19, 6, 3, '17000000.00', '51000000.00'),
(27, 19, 5, 2, '25000000.00', '50000000.00'),
(28, 20, 2, 3, '3500000.00', '10500000.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `stock` int(11) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `product_code`, `name`, `price`, `stock`, `description`, `created_at`) VALUES
(1, 'PRD001', 'Smartphone Samsung A31', '2500000.00', 40, '                      ', '2025-10-26 15:32:19'),
(2, 'PRD002', 'Google TV LED 42\" Sharp Aquos', '3500000.00', 6, '                      ', '2025-10-26 15:32:19'),
(3, 'PRD003', 'Kulkas Dua Pintu', '4200000.00', 15, '                                                                  ', '2025-10-26 15:32:19'),
(5, 'PRD004', 'Asus ROG', '25000000.00', 13, '                                                            laptop gaming kualitas mantap                                                  ', '2025-11-04 19:50:44'),
(6, 'PRD005', 'Lenovo LOQ', '17000000.00', 9, '                 Laptop Gaming Kualitas Terbaik                           ', '2025-11-22 03:54:13'),
(7, 'PRD006', 'Mesin Cuci Aqua 2 Tabung', '2400000.00', 7, '                                            ', '2025-11-22 09:11:03'),
(8, 'PRD007', 'Smartphone Oppo A37', '2600000.00', 10, '                      ', '2025-11-22 17:08:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator - mengelola produk, pelanggan, dan pesanan'),
(2, 'sales', 'Sales - membuat dan melihat pesanan miliknya'),
(3, 'manager', 'Manager - melihat semua laporan penjualan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sales`
--

CREATE TABLE `sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `sales_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sales`
--

INSERT INTO `sales` (`id`, `sales_code`, `name`, `phone`, `email`, `note`, `created_at`) VALUES
(1, 'SALE001', 'Mr Rizky', '08123456789', 'tes.Sales@mail.com', 'Sales Eksekutif', '2025-11-16 01:25:30'),
(5, 'SALE005', 'Rahayu Sales', '08765432110', 'Rahayu.S@mail.com', 'Rahayu Sales Elektronik', '2025-11-16 02:18:41'),
(6, 'SALE006', 'Sugeng', '08123456667', 'Sugeng.sales@mail.com', 'Sales Laptop', '2025-11-22 01:29:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `sales_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `fullname`, `role_id`, `sales_id`, `created_at`, `updated_at`) VALUES
(2, 'admin', '$2y$10$C3V/7Y7Q0b6Y5hXIQ0bGgeiUfEFISSfCoMtkwORP5coPIytPbrbdu', 'Administrator', 1, NULL, '2025-11-04 19:10:23', '2025-11-24 20:10:23'),
(5, 'rahayu', '$2y$10$uhNggQ2daLD8rWpJ1RpjT.i0Ggaw.EO4QCKsRkS0ZzeiIUEgDq41i', 'Rahayu Sales', 2, 1, '2025-11-16 01:45:41', '2025-11-22 17:11:26'),
(7, 'manager01', '$2y$10$r.OpogISV6.Xgh7b/oWEu.xqe3Q57QA.Skn/2gLWdakjhmgghvLka', 'Manager Utama', 3, NULL, '2025-11-16 02:33:02', '2025-11-24 20:09:51');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_code` (`customer_code`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_code` (`order_code`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `sales_id` (`sales_id`),
  ADD KEY `order_date` (`order_date`),
  ADD KEY `status` (`status`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_code` (`product_code`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indeks untuk tabel `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sales_code` (`sales_code`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `sales_id` (`sales_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `audit_log`
--
ALTER TABLE `audit_log`
  ADD CONSTRAINT `audit_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
