<?php
session_start();
if (isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit;
}
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/funciones.php';

$correo = '';
$error  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = mb_strtolower(trim($_POST['correo'] ?? ''));
    $clave  = $_POST['clave'] ?? '';

    $stmt = $mysqli->prepare('SELECT id, nombre, clave_hash FROM usuarios WHERE correo = ?');
    $stmt->bind_param('s', $correo);
    $stmt->execute();
    $usuario = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($usuario && password_verify($clave, $usuario['clave_hash'])) {
        session_regenerate_id(true);
        $_SESSION['uid']    = (int) $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        header('Location: index.php');
        exit;
    }

    $error = 'Correo o contraseña incorrectos.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - AgendaWeb</title>
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
                <h1 class="page__title">Iniciar sesión</h1>
                <p class="page__subtitle">Entra a tu agenda</p>
            </div>
        </div>

        <?php if (isset($_GET['registrado'])): ?>
            <div class="alert alert--ok">Cuenta creada. Ya puedes iniciar sesión.</div>
        <?php endif; ?>
        <?php if (isset($_GET['salio'])): ?>
            <div class="alert alert--ok">Cerraste sesión. ¡Hasta pronto!</div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert--error" role="alert"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="post" action="login.php" class="form-card">
            <div class="campo">
                <label for="correo">Correo</label>
                <input type="email" id="correo" name="correo" required value="<?= e($correo) ?>">
            </div>
            <div class="campo">
                <label for="clave">Contraseña</label>
                <input type="password" id="clave" name="clave" autocomplete="current-password" required>
            </div>

            <button type="submit" class="btn-primary">Entrar</button>
            <a href="registro.php" class="btn-secondary btn-sm">Crear cuenta</a>
        </form>
    </main>

</body>
</html>