<?php
define('DB_HOST', '127.0.0.1');
define('DB_PORT', 3306);
define('DB_USER', 'root');
define('DB_PASS', ''); // <-- Tu contraseña aquí si tienes
define('DB_NAME', 'refugio_lab09');

function db(): PDO {
    static $pdo = null;
    if ($pdo) return $pdo;

    // Crear BD si no existe
    $tmp = new PDO("mysql:host=".DB_HOST.";port=".DB_PORT.";charset=utf8mb4", DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $tmp->exec("CREATE DATABASE IF NOT EXISTS `".DB_NAME."` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $tmp = null;

    // Conectar a la BD
    $pdo = new PDO("mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);

    // Crear tabla
    $pdo->exec("CREATE TABLE IF NOT EXISTS adopciones (
        id INT AUTO_INCREMENT PRIMARY KEY,
        mascota VARCHAR(100) NOT NULL,
        tipo ENUM('Perro', 'Gato') NOT NULL,
        nombre_adoptante VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL,
        fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    return $pdo;
}