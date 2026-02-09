-- ============================================
-- Script de création de la base de données
-- ============================================

-- Création de la base de données
CREATE DATABASE IF NOT EXISTS secure_login_mvc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE secure_login_mvc;

-- Suppression de la table si elle existe
DROP TABLE IF EXISTS users;

-- Création de la table users
CREATE TABLE users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL DEFAULT NULL,
    INDEX idx_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Afficher les tables créées
SHOW TABLES;

