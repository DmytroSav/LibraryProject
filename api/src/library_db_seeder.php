<?php
require 'bootstrap.php';

$statement = <<<EOS
    CREATE TABLE IF NOT EXISTS library (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
content TEXT NOT NULL
);

    CREATE TABLE IF NOT EXISTS users (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255) NOT NULL,
email VARCHAR(255) UNIQUE NOT NULL,
password VARCHAR(255) NOT NULL,
token VARCHAR(255)
);
EOS;

try {
    $createTable = $dbConnection->exec($statement);
    echo "Library database seeded!\n";
} catch (\PDOException $e) {
    exit($e->getMessage());
}
