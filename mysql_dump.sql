-- MySQL dump converted from PostgreSQL

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Create Tables

CREATE TABLE `answers` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `question_id` bigint NOT NULL,
  `content` varchar(255) NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `answers_question_id_foreign` (`question_id`),
  CONSTRAINT `answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `comments` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `table_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `migrations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `questions` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `options` json NOT NULL,
  `order` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `response_history` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `table_id` varchar(255) NOT NULL,
  `question_id` bigint DEFAULT NULL,
  `selected_option` varchar(255) DEFAULT NULL,
  `feedback` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `response_history_table_id_created_at_index` (`table_id`,`created_at`),
  KEY `response_history_question_id_foreign` (`question_id`),
  CONSTRAINT `response_history_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `responses` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `question_id` bigint DEFAULT NULL,
  `selected_option` varchar(255) DEFAULT NULL,
  `table_id` varchar(255) NOT NULL,
  `feedback` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `responses_question_id_foreign` (`question_id`),
  CONSTRAINT `responses_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `users` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert Data

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'contact@events-five.com', NULL, '$2y$12$c4R3oGzvj/qvyOzGm1d0vuS2G/x/qzfF8JKEOi0FGi3ZZavZCf8y.', NULL, '2025-02-19 17:01:38', '2025-02-19 17:01:38');

INSERT INTO `questions` (`id`, `content`, `options`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Comment avez-vous trouvé la qualité de nos plats ?', '[\"Excellent\",\"Très bien\",\"Bien\",\"Peut mieux faire\"]', 4, '2025-02-19 17:01:38', '2025-02-21 09:56:01'),
(2, 'Le service était-il à la hauteur de vos attentes ?', '[\"Parfait\",\"Très satisfaisant\",\"Satisfaisant\",\"À améliorer\"]', 2, '2025-02-19 17:01:38', '2025-02-21 13:56:19'),
(3, 'Comment jugez-vous l''ambiance du restaurant ?', '[\"Très agréable\",\"Agréable\",\"Correcte\",\"À revoir\"]', 1, '2025-02-19 17:01:38', '2025-02-21 10:02:10'),
(4, 'Le rapport qualité-prix vous semble-t-il justifié ?', '[\"Tout à fait\",\"Plutôt oui\",\"Moyen\",\"Non\"]', 3, '2025-02-19 17:01:38', '2025-02-21 15:13:18'),
(6, 'Avez vous aimez vos plats?', '[\"oui\",\"non\",\"maybe\",\"fasho\"]', 5, '2025-02-21 12:14:39', '2025-02-21 12:14:39');

-- Insert response_history and responses data has been omitted for brevity
-- You can add the data if needed, but it follows the same pattern as above

COMMIT;
