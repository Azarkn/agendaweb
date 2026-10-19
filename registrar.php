<?php
require_once 'conexion.php';
require_once 'funciones.php';

$v = ['titulo' => '', 'fecha' => '', 'hora' => '', 'categoria' => '', 'descripcion' => ''];
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $v = leerFormulario();
    $errores = validarEvento($v);

    if (empty($errores)) {
        $hora = $v['hora'] === '' ? null : $v['hora'];
        $descripcion = $v['descripcion'] === '' ? null : $v['descripcion'];

        $stmt = $mysqli->prepare(
            'INSERT INTO eventos (titulo, fecha, hora, categoria, descripcion) VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->bind_param('sssss', $v['titulo'], $v['fecha'], $hora, $v['categoria'], $descripcion);
        $stmt->execute();

        header('Location: index.php?ok=1', true, 303);  
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo evento - AgendaWeb</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos.css?v=<?= filemtime(__DIR__ . '/estilos.css') ?>">
</head>
<body class="layout">

    <header class="site-header">
        <div class="contenedor site-header__inner">
            <a href="index.php" class="logo">Agenda<span>Web</span></a>
            <nav class="nav">
                <a href="index.php" class="nav__link">Mis eventos</a>
                <a href="registrar.php" class="nav__link is-active">Nuevo evento</a>
            </nav>
        </div>
    </header>

    <main class="contenedor">
        <div class="page__header">
            <div>
                <h1 class="page__title">Registrar nuevo evento</h1>
                <p class="page__subtitle">Completa los datos de tu evento</p>
            </div>
        </div>

        <?php if (!empty($errores)): ?>
            <div class="alert alert--error" role="alert">⚠️ Revisa los campos marcados.</div>
        <?php endif; ?>

        <?php mostrarFormulario($v, $errores, '💾 Guardar'); ?>
    </main>

</body>
</html>
