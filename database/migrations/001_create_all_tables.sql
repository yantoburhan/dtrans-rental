-- ============================================================
-- Dtrans Rental — Full Database Schema
-- MySQL 8.0+ | Charset: utf8mb4 | Collation: utf8mb4_unicode_ci
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `dtrans_rental`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `dtrans_rental`;

-- ------------------------------------------------------------
-- users
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
    `id`                        INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `full_name`                 VARCHAR(120) NOT NULL,
    `username`                  VARCHAR(60)  UNIQUE,
    `email`                     VARCHAR(160) NOT NULL UNIQUE,
    `password`                  VARCHAR(255),
    `google_id`                 VARCHAR(100) UNIQUE,
    `avatar`                    VARCHAR(255),
    `phone`                     VARCHAR(20),
    `address`                   TEXT,
    `identity_type`             ENUM('ktp','passport'),
    `identity_file`             VARCHAR(255),
    `role`                      ENUM('admin','customer') NOT NULL DEFAULT 'customer',
    `email_verified_at`         DATETIME,
    `email_verification_token`  VARCHAR(100),
    `password_reset_token`      VARCHAR(100),
    `password_reset_expires`    DATETIME,
    `created_at`                DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`                DATETIME ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_role (`role`),
    INDEX idx_email_token (`email_verification_token`),
    INDEX idx_reset_token (`password_reset_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- drivers
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `drivers` (
    `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id`       INT UNSIGNED UNIQUE COMMENT 'Links to users table for login',
    `full_name`     VARCHAR(120) NOT NULL,
    `photo`         VARCHAR(255),
    `phone`         VARCHAR(20) NOT NULL,
    `email`         VARCHAR(160) NOT NULL UNIQUE,
    `password`      VARCHAR(255) NOT NULL,
    `experience`    TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Years of experience',
    `languages`     VARCHAR(255) COMMENT 'Comma-separated: English, Indonesian, etc.',
    `age`           TINYINT UNSIGNED,
    `status`        ENUM('available','unavailable','inactive') NOT NULL DEFAULT 'available',
    `created_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    DATETIME ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
    INDEX idx_status (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- cars
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `cars` (
    `id`                    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `brand`                 VARCHAR(60)  NOT NULL,
    `model`                 VARCHAR(80)  NOT NULL,
    `year`                  YEAR NOT NULL,
    `plate_number`          VARCHAR(20)  NOT NULL UNIQUE,
    `transmission`          ENUM('manual','automatic') NOT NULL DEFAULT 'automatic',
    `capacity`              TINYINT UNSIGNED NOT NULL COMMENT 'Passenger seats',
    `category`              ENUM('city_car','mpv','suv','luxury','pickup','hiace','electric') NOT NULL,
    `daily_price`           DECIMAL(12,2) NOT NULL,
    `driver_price_per_day`  DECIMAL(12,2) NOT NULL DEFAULT 0,
    `description`           TEXT,
    `photo`                 VARCHAR(255),
    `status`                ENUM('available','unavailable','maintenance') NOT NULL DEFAULT 'available',
    `created_at`            DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`            DATETIME ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (`category`),
    INDEX idx_status (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- car_photos
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `car_photos` (
    `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `car_id`        INT UNSIGNED NOT NULL,
    `photo_path`    VARCHAR(255) NOT NULL,
    `sort_order`    TINYINT UNSIGNED NOT NULL DEFAULT 0,
    FOREIGN KEY (`car_id`) REFERENCES `cars`(`id`) ON DELETE CASCADE,
    INDEX idx_car_sort (`car_id`, `sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- bookings
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `bookings` (
    `id`                    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `booking_code`          VARCHAR(30) NOT NULL UNIQUE,
    `user_id`               INT UNSIGNED NOT NULL,
    `car_id`                INT UNSIGNED NOT NULL,
    `driver_id`             INT UNSIGNED,
    `pickup_date`           DATE NOT NULL,
    `return_date`           DATE NOT NULL,
    `total_days`            SMALLINT UNSIGNED NOT NULL,
    `car_price`             DECIMAL(14,2) NOT NULL,
    `driver_price`          DECIMAL(14,2) NOT NULL DEFAULT 0,
    `late_penalty`          DECIMAL(14,2) NOT NULL DEFAULT 0,
    `total_price`           DECIMAL(14,2) NOT NULL,
    `payment_method`        ENUM('bank_transfer','e_wallet','cod','midtrans') NOT NULL,
    `notes`                 TEXT,
    `status`                ENUM('pending','waiting_payment','approved','ongoing','completed','cancelled') NOT NULL DEFAULT 'pending',
    `admin_note`            TEXT,
    `cancelled_at`          DATETIME,
    `cancellation_reason`   TEXT,
    `created_at`            DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`            DATETIME ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`)   REFERENCES `users`(`id`) ON DELETE RESTRICT,
    FOREIGN KEY (`car_id`)    REFERENCES `cars`(`id`) ON DELETE RESTRICT,
    FOREIGN KEY (`driver_id`) REFERENCES `drivers`(`id`) ON DELETE SET NULL,
    INDEX idx_status (`status`),
    INDEX idx_dates (`pickup_date`, `return_date`),
    INDEX idx_user (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- payments
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `payments` (
    `id`                INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `booking_id`        INT UNSIGNED NOT NULL UNIQUE,
    `method`            VARCHAR(60),
    `amount`            DECIMAL(14,2) NOT NULL,
    `status`            ENUM('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
    `midtrans_order_id` VARCHAR(100),
    `midtrans_token`    TEXT,
    `proof_file`        VARCHAR(255) COMMENT 'Manual transfer proof upload',
    `paid_at`           DATETIME,
    `created_at`        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- driver_reviews
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `driver_reviews` (
    `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `driver_id`     INT UNSIGNED NOT NULL,
    `user_id`       INT UNSIGNED NOT NULL,
    `booking_id`    INT UNSIGNED NOT NULL UNIQUE COMMENT 'One review per completed booking',
    `rating`        TINYINT UNSIGNED NOT NULL COMMENT '1-5 stars',
    `comment`       TEXT,
    `created_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`driver_id`)  REFERENCES `drivers`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`user_id`)    REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`id`) ON DELETE CASCADE,
    CHECK (`rating` BETWEEN 1 AND 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- tourism_destinations
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `tourism_destinations` (
    `id`                    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name`                  VARCHAR(160) NOT NULL,
    `description`           TEXT,
    `location`              VARCHAR(255),
    `maps_embed_url`        TEXT,
    `ticket_price`          DECIMAL(12,2) NOT NULL DEFAULT 0,
    `recommended_vehicle`   VARCHAR(100),
    `created_at`            DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`            DATETIME ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- tourism_photos
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `tourism_photos` (
    `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `destination_id` INT UNSIGNED NOT NULL,
    `photo_path`    VARCHAR(255) NOT NULL,
    `sort_order`    TINYINT UNSIGNED NOT NULL DEFAULT 0,
    FOREIGN KEY (`destination_id`) REFERENCES `tourism_destinations`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- chat_messages
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `chat_messages` (
    `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id`       INT UNSIGNED NOT NULL,
    `sender`        ENUM('customer','admin') NOT NULL,
    `message`       TEXT NOT NULL,
    `is_read`       TINYINT(1) NOT NULL DEFAULT 0,
    `created_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX idx_user_read (`user_id`, `is_read`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- activity_logs
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `activity_logs` (
    `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id`       INT UNSIGNED,
    `action`        VARCHAR(120) NOT NULL,
    `description`   TEXT,
    `ip_address`    VARCHAR(45),
    `created_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
    INDEX idx_created (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Default admin account
-- password: Admin@123 (bcrypt — change immediately after setup)
-- ------------------------------------------------------------
INSERT INTO `users` (`full_name`, `username`, `email`, `password`, `role`, `email_verified_at`) VALUES
('Super Admin', 'admin', 'admin@dtransrental.com',
 '$2y$12$MI7sYeYmb0K8BmCF4yN.6.S8060X86808M8UdFzqRI85oRzqHD/0O',
 'admin', NOW());

-- ------------------------------------------------------------
-- Dummy data: Cars
-- ------------------------------------------------------------
INSERT INTO `cars` (`brand`, `model`, `year`, `plate_number`, `transmission`, `capacity`, `category`, `daily_price`, `driver_price_per_day`, `description`, `status`) VALUES
('Toyota', 'Avanza', 2020, 'BK 1234 AB', 'automatic', 7, 'mpv', 250000, 150000, 'Comfortable MPV for family trips', 'available'),
('Honda', 'Brio', 2021, 'BK 5678 CD', 'manual', 5, 'city_car', 200000, 120000, 'Fuel-efficient city car', 'available'),
('Mitsubishi', 'Pajero', 2019, 'BK 9012 EF', 'automatic', 7, 'suv', 400000, 200000, 'Powerful SUV for adventures', 'available'),
('Toyota', 'Hiace', 2022, 'BK 3456 GH', 'automatic', 12, 'hiace', 500000, 250000, 'Large van for groups', 'available');

-- ------------------------------------------------------------
-- Dummy data: Drivers
-- ------------------------------------------------------------
INSERT INTO `drivers` (`full_name`, `phone`, `email`, `password`, `experience`, `languages`, `age`, `status`) VALUES
('Ahmad Rahman', '081234567890', 'ahmad@example.com', '$2y$10$dummyhash', 5, 'Indonesian, English', 35, 'available'),
('Siti Nurhaliza', '081234567891', 'siti@example.com', '$2y$10$dummyhash', 3, 'Indonesian', 28, 'available'),
('Budi Santoso', '081234567892', 'budi@example.com', '$2y$10$dummyhash', 7, 'Indonesian, English, Mandarin', 42, 'available');

-- ------------------------------------------------------------
-- Dummy data: Tourism Destinations
-- ------------------------------------------------------------
INSERT INTO `tourism_destinations` (`name`, `description`, `location`, `ticket_price`, `recommended_vehicle`) VALUES
('Lake Toba', 'Beautiful volcanic lake with stunning views', 'North Sumatra', 50000, 'SUV or MPV'),
('Samosir Island', 'Island in the middle of Lake Toba with rich culture', 'North Sumatra', 75000, 'MPV'),
('Sipiso-Piso Waterfall', 'Spectacular waterfall in a canyon', 'North Sumatra', 25000, 'City Car');

-- Add photo column to cars if not exists
ALTER TABLE cars ADD COLUMN IF NOT EXISTS photo VARCHAR(255);

SET FOREIGN_KEY_CHECKS = 1;
