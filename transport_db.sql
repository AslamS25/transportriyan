/*
 Navicat Premium Data Transfer

 Source Server         : Cooper
 Source Server Type    : MariaDB
 Source Server Version : 101109 (10.11.9-MariaDB)
 Source Host           : localhost:3307
 Source Schema         : transport_db

 Target Server Type    : MariaDB
 Target Server Version : 101109 (10.11.9-MariaDB)
 File Encoding         : 65001

 Date: 15/07/2025 12:37:31
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `address` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO `customers` VALUES (3, 'Rudi Hartono', '081212345001', 'Jl. Adisucipto No.10, Pontianak');
INSERT INTO `customers` VALUES (4, 'Siti Aminah', '081212345002', 'Jl. A. Yani II No.25, Pontianak');
INSERT INTO `customers` VALUES (5, 'Dedi Saputra', '081212345003', 'Jl. Zainuddin, Putussibau');
INSERT INTO `customers` VALUES (6, 'Maya Rachmawati', '081212345004', 'Jl. Tanjungpura No.88, Pontianak');
INSERT INTO `customers` VALUES (7, 'Andi Firmansyah', '081212345005', 'Jl. Lintas Utara, Putussibau');
INSERT INTO `customers` VALUES (8, 'Linda Marlina', '081212345006', 'Jl. Merdeka, Pontianak');
INSERT INTO `customers` VALUES (9, 'Budi Susanto', '081212345007', 'Jl. Kom Yos Sudarso, Putussibau');
INSERT INTO `customers` VALUES (10, 'Rina Oktaviani', '081212345008', 'Jl. Gajah Mada No.45, Pontianak');
INSERT INTO `customers` VALUES (11, 'Tono Wijaya', '081212345009', 'Jl. Trans Kalimantan, Putussibau');
INSERT INTO `customers` VALUES (12, 'Yuni Safitri', '081212345010', 'Jl. Imam Bonjol No.9, Pontianak');

-- ----------------------------
-- Table structure for drivers
-- ----------------------------
DROP TABLE IF EXISTS `drivers`;
CREATE TABLE `drivers`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `license_number` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of drivers
-- ----------------------------
INSERT INTO `drivers` VALUES (1, 'Agus Santoso', '081234567890', 'SIM123456');
INSERT INTO `drivers` VALUES (2, 'Budi Hartono', '082112345678', 'SIM234567');
INSERT INTO `drivers` VALUES (3, 'Citra Dewi', '085612345678', 'SIM345678');
INSERT INTO `drivers` VALUES (4, 'Dedi Pratama', '081398765432', 'SIM456789');
INSERT INTO `drivers` VALUES (5, 'Eka Wulandari', '089512345678', 'SIM567890');
INSERT INTO `drivers` VALUES (6, 'Fajar Maulana', '087712345678', 'SIM678901');

-- ----------------------------
-- Table structure for fleet
-- ----------------------------
DROP TABLE IF EXISTS `fleet`;
CREATE TABLE `fleet`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plate_number` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `brand` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `type` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `year` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of fleet
-- ----------------------------
INSERT INTO `fleet` VALUES (1, 'KB1234AB', 'Mitsubishi', 'Canter', 2020);
INSERT INTO `fleet` VALUES (2, 'KB4321CD', 'Toyota', 'Dyna', 2021);
INSERT INTO `fleet` VALUES (3, 'KB5678EF', 'Isuzu', 'Elf', 2019);
INSERT INTO `fleet` VALUES (4, 'KB8765GH', 'Hino', 'Dutro', 2022);

-- ----------------------------
-- Table structure for shipments
-- ----------------------------
DROP TABLE IF EXISTS `shipments`;
CREATE TABLE `shipments`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NULL DEFAULT NULL,
  `driver_id` int(11) NULL DEFAULT NULL,
  `fleet_id` int(11) NULL DEFAULT NULL,
  `destination` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `shipment_date` date NULL DEFAULT NULL,
  `status` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'Dijadwalkan',
  `note` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT current_timestamp(),
  `shipping_cost` decimal(10, 2) NULL DEFAULT 0.00,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `customer_id`(`customer_id`) USING BTREE,
  INDEX `driver_id`(`driver_id`) USING BTREE,
  INDEX `shipments_ibfk_3`(`fleet_id`) USING BTREE,
  CONSTRAINT `shipments_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `shipments_ibfk_2` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `shipments_ibfk_3` FOREIGN KEY (`fleet_id`) REFERENCES `fleet` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shipments
-- ----------------------------
INSERT INTO `shipments` VALUES (11, NULL, 1, 1, 'Pontianak - Singkawang', '2025-07-10', 'Menunggu', 'Barang siap di gudang', 180000.00);
INSERT INTO `shipments` VALUES (12, NULL, 2, 2, 'Pontianak - Sambas', '2025-07-09', 'Dalam Perjalanan', 'Bawa paket elektronik', 250000.00);
INSERT INTO `shipments` VALUES (13, NULL, 3, 3, 'Pontianak - Ketapang', '2025-07-08', 'Terkirim', 'Sampai dengan aman', 400000.00);
INSERT INTO `shipments` VALUES (14, NULL, 4, 1, 'Pontianak - Sanggau', '2025-07-07', 'Terkirim', 'Pengiriman cepat', 220000.00);
INSERT INTO `shipments` VALUES (15, NULL, 5, 4, 'Pontianak - Mempawah', '2025-07-06', 'Dalam Perjalanan', 'Termasuk bahan pangan', 150000.00);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `role` enum('admin','staff') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'staff',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'admin', '$2y$10$qtgWPo4IkgzmJtgrPYYs9OdMRskqD5Axgt1EwAmU2d3xJ7KRqG7n6', 'staff');

SET FOREIGN_KEY_CHECKS = 1;
