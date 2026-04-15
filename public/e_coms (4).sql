-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2026 at 09:54 AM
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
-- Database: `e_coms`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(5, 19, 2, 2),
(34, 1, 2, 3),
(35, 1, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 2, 2, 3, 0.00),
(2, 2, 1, 1, 0.00),
(3, 2, 3, 1, 0.00),
(4, 3, 1, 1, 0.00),
(5, 3, 6, 1, 0.00),
(6, 4, 2, 3, 0.00),
(9, 9, 2, 1, 130.00),
(10, 10, 1, 1, 120.00),
(11, 10, 3, 4, 140.00),
(12, 11, 2, 1, 0.00),
(13, 11, 8, 3, 0.00),
(14, 12, 7, 3, 420.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `COnumber` varchar(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `totalPrice` decimal(10,2) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contactNumber` varchar(20) DEFAULT NULL,
  `paymentMethod` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `DateCreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `COnumber`, `user_id`, `totalPrice`, `address`, `contactNumber`, `paymentMethod`, `status`, `DateCreated`) VALUES
(1, '0', 12, 715.00, 'nazareth, nazareth, cdo', '0905212451', '', 'Pending', '2026-04-13 19:32:39'),
(2, '0', 12, 715.00, 'pabayo hayes', '0905212451', '', 'Pending', '2026-04-13 19:33:10'),
(3, '0', 12, 297.00, 'pabayo hayes', '0905212451', '', 'Pending', '2026-04-13 19:38:12'),
(4, '0', 12, 429.00, 'pabayo hayes', '0905212451', 'gcash', 'Pending', '2026-04-13 19:42:19'),
(5, '0', 12, 143.00, 'pabayo hayes', '0905212451', 'Cash on delievery', 'Pending', '2026-04-13 19:47:01'),
(6, '0', 12, 143.00, 'pabayo hayes', '0905212451', 'Cash on delievery', 'Pending', '2026-04-13 19:48:30'),
(7, '0', 12, 143.00, 'nazareth, nazareth, cdo', '0905212451', 'gcash', 'Pending', '2026-04-13 19:49:44'),
(8, '0', 12, 143.00, 'nazareth, nazareth, cdo', '0905212451', 'gcash', 'Pending', '2026-04-13 19:51:31'),
(9, '0', 12, 143.00, 'nazareth, nazareth, cdo', '0905212451', 'gcash', 'Pending', '2026-04-13 19:53:02'),
(10, '0', 12, 748.00, 'nazareth, nazareth, cdo', '0905212451', 'COD', 'Pending', '2026-04-13 19:53:35'),
(11, '0', 12, 638.00, 'nazareth, nazareth, cdo', '0905212451', 'COD', 'Pending', '2026-04-13 20:00:16'),
(12, 'CO00012', 12, 462.00, 'nazareth, nazareth, cdo', '0905212451', 'cod', 'Pending', '2026-04-13 20:02:49');

-- --------------------------------------------------------

--
-- Table structure for table `product_item`
--

CREATE TABLE `product_item` (
  `id` int(11) NOT NULL,
  `uuid` int(11) DEFAULT NULL,
  `productName` varchar(50) DEFAULT NULL,
  `productDescription` varchar(50) DEFAULT NULL,
  `price` decimal(3,0) DEFAULT NULL,
  `img` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_item`
--

INSERT INTO `product_item` (`id`, `uuid`, `productName`, `productDescription`, `price`, `img`) VALUES
(1, NULL, 'Vanilla Éclair', 'Classic éclair filled with smooth vanilla cream an', 120, 'vanilla3.jpg'),
(2, NULL, 'Strawberry Éclair', 'Light éclair filled with sweet strawberry cream.', 130, 'eclair3.jpg'),
(3, NULL, 'Chocolate Éclair', 'Rich chocolate-filled éclair with glossy chocolate', 140, 'choco2.jpg'),
(4, NULL, 'Strawberry Tops', 'Éclair infused with coffee cream for a bold flavor', 135, 'strawberry_tops.jpg'),
(5, NULL, 'Caramel Éclair', 'Sweet caramel cream filling with caramel drizzle o', 145, 'E-7.jpg'),
(6, NULL, 'Ube Éclair', 'Filipino-style éclair with creamy ube filling.', 150, 'E-6.jpg'),
(7, NULL, 'Mango Éclair', 'Fresh mango cream filling with a tropical taste.', 140, 'E-12.jpg'),
(8, NULL, 'Cookies & Cream Éclair', 'Filled with cookies and cream mixture, crunchy and', 150, 'E-11.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `uuid` int(11) DEFAULT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `middleName` varchar(255) DEFAULT NULL,
  `emailAddress` varchar(255) DEFAULT NULL,
  `contactNumber` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `firstName`, `lastName`, `middleName`, `emailAddress`, `contactNumber`, `username`, `password`, `street`, `barangay`, `city`, `role`, `dateCreated`) VALUES
(1, NULL, 'sam', 'rookie', NULL, 'sam@gmail.com', '0941249012', 'sammy', 'manok', 'tomasaco', 'nazareto', 'cdo', 'user', '2026-04-02 06:07:45'),
(2, 15, 'sam', 'roque', '', '', '40194120941', 'manoks', 'manoks', 'pabao', 'naza', 'cdo', 'user', '2026-04-02 06:07:45'),
(3, 0, 'sam', 'roque', '', 'samroque959@gmail.com', '312321', '', '12345', 'Pabayo St', '12345', 'Cagayan de Oro', 'user', '2026-04-02 06:07:45'),
(4, 0, 'marjon', 'osa', '', 'marjon@gmail.com', '090524124', 'marjons', 'marzon', 'canitoan', 'uptown?', 'cdo', 'user', '2026-04-02 06:07:45'),
(5, 0, 'Sam', 'Roque', 'lagcao', 'roque.sam05@gmail.com', '0905253', 'manokannssss', '', '', '', '', 'user', '2026-04-02 06:07:45'),
(6, 826, 'Sam', 'Roque', 'lagcao', 'roque.sam052@gmail.com', '09052531699', 'manny', 'sammy', 'hayes', 'nazareth', 'cdo', 'user', '2026-04-02 06:07:45'),
(7, 0, 'sam', 'rookie', '', 'samms@gmail.com', '090525315211', 'manok', 'sammy', 'pabayo ', 'nazareth', 'cdo', 'user', '2026-04-02 06:07:45'),
(8, 96, 'sam', 'rookie', '', 'sammss@gmail.com', '090525315211', 'manokanss', 'sam', 'pabayo ', 'nazareth', 'cdo', 'user', '2026-04-02 06:07:45'),
(9, 0, 'carlo', 'veloso', '', 'carlo@gmail.com', '090942121', 'carlotta', 'mans', 'pabayo ', 'nazareth', 'cdo', 'user', '2026-04-02 06:07:45'),
(10, 0, 'sam', 'rookie', '', 'sammsssss@gmail.com', '090525315211', 'manoka2', 'sam', 'pabayo ', 'nazareth', 'cdo', 'user', '2026-04-02 06:07:45'),
(11, 7222, 'sam', 'rookie', '', 'sammfafsss@gmail.com', '090525315211', 'manok1', '1234', 'pabayo ', 'nazareth', 'cdo', 'user', '2026-04-02 06:07:45'),
(12, 61319297, 'sam', 'rookies', 'manok', 'sammy1@gmail.com', '0905212451', 'manokansabuko', 'manok', 'nazareth', 'nazareth', 'cdo', 'user', '2026-04-02 06:07:45'),
(13, NULL, 'sam', 'roque', NULL, 'sam959@gmail.com', '0904291222', 'sammypopo', 'manok', 'pabayo', 'nazareth', 'cdo', 'admin', '2026-04-02 06:07:45'),
(14, 0, 'sam', 'rookie', '', 'roque.sam0541@gmail.com', '0905215213', 'samms', 'manok', 'pabayo', 'nazareth', 'cdo', 'user', '2026-04-02 06:07:45'),
(15, 1, 'sam', 'roque', '', 'manokss@gmail.com', '0905921', 'sammy121', 'manok', 'pabayo', 'nazareth', 'cdo', 'user', '2026-04-02 06:08:16'),
(16, 0, 'sam', 'roque', '', 'sammm@gmail.com', '0905213121', 'sammyss', 'manok', 'tomasaco', 'nazreth', 'cdo', 'user', '2026-04-03 06:08:20'),
(17, 0, 'sam', 'roque', '', 'sam959222@gmail.com', '090052244', 'sammy212', 'manok', 'tomasaco', 'nazareth', 'cdo', 'user', '2026-04-03 06:58:54'),
(18, 0, 'sam', 'roque', '', 'roque.sam0521@gmail.com', '095215215', 'sammy1', 'manok', 'tomasaco', 'nazareth', 'cdo', 'user', '2026-04-06 07:19:07'),
(19, 7, 'sam', 'roque', '', 'rookies1@gmail.com', '094211241', 'sammy2', 'manok', 'tomasaco', 'nazareth', 'cdo', 'user', '2026-04-06 07:21:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_product_id` (`product_id`);

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_item`
--
ALTER TABLE `product_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_item`
--
ALTER TABLE `product_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `product_item` (`ID`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `orderitems_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_item` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
