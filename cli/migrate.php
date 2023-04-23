<?php

$config = require_once 'config/env.php';
$dbConfig = $config['db'];

$migrations = array_diff(scandir('database/migrations'), array('..', '.'));

try {
    $conn = new PDO("mysql:host=" . $dbConfig['host'] . ";dbname=" . $dbConfig['database_name'], $dbConfig['user_name'], $dbConfig['password']);

    foreach ($migrations as $migration) {
        $sql = file_get_contents('database/migrations/'.$migration);
        $conn->exec($sql);
    }

    $conn = null;

    echo 'Tables established';
} catch (PDOException $e) {
    echo $e->getMessage();
}
