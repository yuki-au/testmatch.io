-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Mar 26, 2021 at 02:08 PM
-- Server version: 8.0.18
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `match`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `cartID` int(10) NOT NULL AUTO_INCREMENT,
  `userID` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`cartID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cartproduct`
--

DROP TABLE IF EXISTS `cartproduct`;
CREATE TABLE IF NOT EXISTS `cartproduct` (
  `cartproductID` int(10) NOT NULL AUTO_INCREMENT,
  `cartID` int(10) NOT NULL,
  `productID` int(10) NOT NULL,
  `quantity` smallint(6) NOT NULL,
  PRIMARY KEY (`cartproductID`),
  KEY `cartID` (`cartID`),
  KEY `productID` (`productID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `categoryID` int(10) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(50) NOT NULL,
  PRIMARY KEY (`categoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryID`, `categoryName`) VALUES
(1, 'Cheerful'),
(2, 'Calm'),
(3, 'Mysterious'),
(4, 'Energestic'),
(5, 'Peaceful'),
(6, 'Aggressive'),
(7, 'Confident'),
(8, 'Thankful');

-- --------------------------------------------------------

--
-- Table structure for table `orderdata`
--

DROP TABLE IF EXISTS `orderdata`;
CREATE TABLE IF NOT EXISTS `orderdata` (
  `OrderNumber` int(10) NOT NULL AUTO_INCREMENT,
  `orderDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `deliverDate` varchar(10) NOT NULL,
  `userID` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`OrderNumber`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

DROP TABLE IF EXISTS `order_product`;
CREATE TABLE IF NOT EXISTS `order_product` (
  `order_productID` int(10) NOT NULL AUTO_INCREMENT,
  `OrderNumber` int(10) NOT NULL,
  `productID` int(10) NOT NULL,
  `quantity` smallint(6) NOT NULL,
  PRIMARY KEY (`order_productID`),
  KEY `productID` (`productID`),
  KEY `OrderNumber` (`OrderNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `productID` int(10) NOT NULL AUTO_INCREMENT,
  `productName` varchar(50) NOT NULL,
  `categoryID` int(10) NOT NULL,
  PRIMARY KEY (`productID`),
  KEY `categoryID` (`categoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productID`, `productName`, `categoryID`) VALUES
(1, 'dress', 1),
(2, 'tablelight', 2),
(3, 'shirt', 3),
(4, 'hat', 4),
(5, 'phonecase', 5),
(6, 'bag', 6),
(7, 'watch', 7),
(8, 'mirror', 8);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  `homeaddress` varchar(100) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `mobilenumber` int(10) DEFAULT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `password`, `homeaddress`, `state`, `mobilenumber`) VALUES
(1, 'us1', '1', NULL, NULL, NULL),
(2, 'us2', '2', NULL, NULL, NULL),
(3, 'us3', '3', NULL, NULL, NULL),
(4, 'us4', '3', NULL, NULL, NULL),
(5, 'us5', '5', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usercategory`
--

DROP TABLE IF EXISTS `usercategory`;
CREATE TABLE IF NOT EXISTS `usercategory` (
  `usercatgoryID` int(10) NOT NULL AUTO_INCREMENT,
  `categoryID` int(10) DEFAULT NULL,
  `userID` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`usercatgoryID`),
  KEY `categoryID` (`categoryID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usercategory`
--

INSERT INTO `usercategory` (`usercatgoryID`, `categoryID`, `userID`) VALUES
(95, 2, 1),
(96, 3, 1),
(97, 4, 1),
(100, 5, 2),
(101, 6, 2),
(102, 7, 2),
(103, 8, 2),
(107, 1, 4),
(108, 2, 4),
(109, 3, 4),
(110, 4, 4),
(113, 1, 5),
(114, 2, 5),
(115, 3, 5),
(116, 4, 5),
(117, 5, 5);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cartproduct`
--
ALTER TABLE `cartproduct`
  ADD CONSTRAINT `cartproduct_ibfk_1` FOREIGN KEY (`cartID`) REFERENCES `cart` (`cartID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cartproduct_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderdata`
--
ALTER TABLE `orderdata`
  ADD CONSTRAINT `orderdata_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_product_ibfk_2` FOREIGN KEY (`OrderNumber`) REFERENCES `orderdata` (`OrderNumber`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usercategory`
--
ALTER TABLE `usercategory`
  ADD CONSTRAINT `usercategory_ibfk_1` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usercategory_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
