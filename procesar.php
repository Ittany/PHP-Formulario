<?php
require __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validación con filter_input (Según la guía)
    $mascota = filter_input(INPUT_POST, 'mascota', FILTER_SANITIZE_SPECIAL_CHARS);
    $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_SPECIAL_CHARS);
    $nombre = filter_input(INPUT_POST, 'nombre_adoptante', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if ($mascota && $tipo && $nombre && $email) {
        try {
            $stmt = db()->prepare("INSERT INTO adopciones (mascota, tipo, nombre_adoptante, email) VALUES (?, ?, ?, ?)");
            $stmt->execute([$mascota, $tipo, $nombre, $email]);
            
            // 302 Redirect (Paso 4 de la guía)
            header("Location: index.php?status=success");
            exit;
        } catch (Exception $e) {
            header("Location: index.php?status=error");
            exit;
        }
    } else {
        header("Location: index.php?status=invalid");
        exit;
    }
}
// Si intentan entrar directo a procesar.php sin POST
header("Location: index.php");
exit;