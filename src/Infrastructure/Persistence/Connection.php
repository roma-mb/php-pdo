<?php

namespace Pdo\Infrastructure\Persistence;

use PDO;

class Connection
{
    public static function create(): PDO
    {
        $path = __DIR__ . '/../../database/local.sqlite';
        //$connection =  new PDO('sqlite:' . $path);
        $connection = new PDO('mysql:host=localhost;dbname=pdo-database', 'root', 'root');
        //https://www.php.net/manual/pt_BR/pdo.setattribute.php
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $connection;
    }
}
