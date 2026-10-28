<?php
session_start();
if (isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit;
}
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/funciones.php';

$nombre = $correo = '';
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = mb_strtolower(trim($_POST['correo'] ?? ''));
    $clave  = $_POST['clave']  ?? '';
    $clave2 = $_POST['clave2'] ?? '';

    if ($nombre === '' || mb_strlen($nombre) > 80) {
        $errores['nombre'] = 'Escribe tu nombre (máximo 80 caracteres).';
    }
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = 'Escribe un correo válido.';
    }
    if (mb_strlen($clave) < 8) {
        $errores['clave'] = 'La contraseña debe tener al menos 8 caracteres.';
    } elseif ($clave !== $clave2) {
        $errores['clave2'] = 'Las contraseñas no coinciden.';
    }

    if (empty($errores)) {
        $hash = password_hash($clave, PASSWORD_DEFAULT);
        try {
            $stmt = $mysqli->prepare('INSERT INTO usuarios (nombre, correo, clave_hash) VALUES (?, ?, ?)');
            $stmt->bind_param('sss', $nombre, $correo, $hash);
            $stmt->execute();
            header('Location: login.php?registrado=1');
            exit;
        } catch (mysqli_sql_exception $ex) {
            if ((int) $ex->getCode() === 1062) {
                $errores['correo'] = 'Ese correo ya tiene una cuenta.';
            } else {
                $errores['general'] = 'No se pudo crear la cuenta. Intenta de nuevo.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta - AgendaWeb</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos.css?v=<?= filemtime(__DIR__ . '/estilos.css') ?>">
</head>
<body class="layout">

    <header class="site-header">
        <div class="contenedor site-header__inner">
            <a href="login.php" class="logo">Agenda<span>Web</span></a>
        </div>
    </header>

    <main class="contenedor">
        <div class="page__header">
            <div>
                <h1 class="page__title">Crear cuenta</h1>
                <p class="page__subtitle">Tu agenda, solo tuya</p>
            </div>
        </div>

        <?php if (isset($errores['general'])): ?>
            <div class="alert alert--error" role="alert"><?= e($errores['general']) ?></div>
        <?php endif; ?>

        <form method="post" action="registro.php" class="form-card">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" maxlength="80" required value="<?= e($nombre) ?>">
                <?= mensajeError($errores, 'nombre') ?>
            </div>
            <div class="campo">
                <label for="correo">Correo</label>
                <input type="email" id="correo" name="correo" required value="<?= e($correo) ?>">
                <?= mensajeError($errores, 'correo') ?>
            </div>
            <div class="campo">
                <label for="clave">Contraseña</label>
                <input type="password" id="clave" name="clave" minlength="8" autocomplete="new-password" required>
                <?= mensajeError($errores, 'clave') ?>
            </div>
            <div class="campo">
                <label for="clave2">Repítela</label>
                <input type="password" id="clave2" name="clave2" minlength="8" autocomplete="new-password" required>
                <?= mensajeError($errores, 'clave2') ?>
            </div>

            <button type="submit" class="btn-primary">Crear cuenta</button>
            <a href="login.php" class="btn-secondary btn-sm">Ya tengo cuenta</a>
        </form>
    </main>

</body>
</html>