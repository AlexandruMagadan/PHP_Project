<?php
require_once 'connection.php';
$connectDb = new Connection();
$pdo = $connectDb->connect();

$pdo->exec("CREATE TABLE IF NOT EXISTS authors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    photo VARCHAR(255) NOT NULL,
    age INT NOT NULL,
    id_publisher INT NOT NULL,
    deleted TINYINT(1) DEFAULT 0
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS publishers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    logo VARCHAR(255) NOT NULL,
    deleted TINYINT(1) DEFAULT 0
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    product_photo VARCHAR(255) NOT NULL,
    id_author INT NOT NULL,
    id_publisher INT NOT NULL,
    publishing_date DATE NOT NULL,
    deleted TINYINT(1) DEFAULT 0,
    FOREIGN KEY (id_author) REFERENCES authors(id),
    FOREIGN KEY (id_publisher) REFERENCES publishers(id)
)");