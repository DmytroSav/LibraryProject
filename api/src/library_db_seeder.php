<?php
require 'bootstrap.php';

$statement = <<<EOS
    CREATE TABLE IF NOT EXISTS library (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
content TEXT NOT NULL
);

    INSERT INTO library (user_id, content) values
(1, 'Kurt Vonnegut "Galapogoses"'),
(1, 'Richard Dawkins "The Selfish gene"'),
(2, 'Stephen King "Doctor Sleep"'),
(2, 'Stephen King "It"'),
(3, 'Jorge Luis Borges "The book of send"'),
(3, 'Ayn Rand "Atlas shrugged"');
EOS;

try {
    $createTable = $dbConnection->exec($statement);
    echo "Library database seeded!\n";
} catch (\PDOException $e) {
    exit($e->getMessage());
}
