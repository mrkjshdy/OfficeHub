<?php

$host = "sql112.infinityfree.com";
$dbname = "if0_42443475_officehub";
$username = "if0_42443475";
$password = "N3M4l4FaEKGy";

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $e) {

    die("Database Connection Failed: " . $e->getMessage());

}