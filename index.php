<?php
require __DIR__ . '/config.php';
$adopciones = db()->query("SELECT * FROM adopciones ORDER BY id DESC")->fetchAll();
$status = $_GET['status'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Refugio de Mascotas - Lab 09</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>🐾 Refugio de Gatos y Perros</h1>
        <p>Formulario de Adopción - Semana 09</p>
    </header>

    <?php if ($status === 'success'): ?>
        <div class="alerta exito">✅ ¡Adopción registrada con éxito! (Status 302 Redirect)</div>
    <?php elseif ($status === 'invalid'): ?>
        <div class="alerta error">❌ Datos inválidos. Revisa el email o los campos vacíos.</div>
    <?php endif; ?>

    <form action="procesar.php" method="POST">
        <label>Nombre de la mascota:
            <input type="text" name="mascota" required placeholder="Ej: Firulais">
        </label>
        <label>Tipo de mascota:
            <select name="tipo" required>
                <option value="Perro">Perro</option>
                <option value="Gato">Gato</option>
            </select>
        </label>
        <label>Tu nombre:
            <input type="text" name="nombre_adoptante" required placeholder="Ej: Brittany">
        </label>
        <label>Tu correo:
            <input type="email" name="email" required placeholder="correo@ejemplo.com">
        </label>
        <button type="submit">Registrar Adopción</button>
    </form>

    <h2>📋 Adopciones Recientes (<?= count($adopciones) ?>)</h2>
    <div class="grid">
        <?php foreach ($adopciones as $a): ?>
            <div class="card <?= strtolower($a['tipo']) ?>">
                <h3><?= $a['tipo'] === 'Perro' ? '🐶' : '🐱' ?> <?= htmlspecialchars($a['mascota']) ?></h3>
                <p>Adoptado por: <strong><?= htmlspecialchars($a['nombre_adoptante']) ?></strong></p>
                <small>📧 <?= htmlspecialchars($a['email']) ?></small>
                <br><small>📅 <?= $a['fecha'] ?></small>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>