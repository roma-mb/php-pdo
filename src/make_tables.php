<?php

use Pdo\Infrastructure\Persistence\Connection;

require('vendor/autoload.php');

$connection = Connection::create();

$query = '
CREATE TABLE IF NOT EXISTS students (
    id INTEGER PRIMARY KEY,
    name TEXT,
    birth_date TEXT
);

CREATE TABLE IF NOT EXISTS phones (
    id INTEGER PRIMARY KEY,
    area_code TEXT,
    number TEXT,
    student_id TEXT,
    FOREIGN KEY(student_id) REFERENCES students (id)
);
';
dd($connection->exec($query));
