<?php
require_once 'conexion.php';
require_once 'funciones.php';

// De dónde sale el id:
//   al ABRIR (GET)    → de la URL: editar.php?id=5 (el botón "Editar" de la lista)
//   al GUARDAR (POST) → del campo oculto <input type="hidden" name="id"> del formulario
$id = $_SERVER['REQUEST_METHOD'] === 'POST' ? ($_POST['id'] ?? '') : ($_GET['id'] ?? '');
$id = is_string($id) && ctype_digit($id) ? (int) $id : 0;   // el id solo puede ser un número

// El evento tiene que existir
$stmt = $mysqli->prepare('SELECT id, titulo, fecha, hora, categoria, descripcion FROM eventos WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$evento = $stmt->get_result()->fetch_assoc();
if (!$evento) {
    header('Location: index.php?noexiste=1', true, 303);
    exit;
}

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $v = leerFormulario();
    $errores = validarEvento($v);

    if (empty($errores)) {
        $hora = $v['hora'] === '' ? null : $v['hora'];
        $descripcion = $v['descripcion'] === '' ? null : $v['descripcion'];

        // WHERE id = ?: cambia SOLO este evento
        $stmt = $mysqli->prepare(
            'UPDATE eventos SET titulo = ?, fecha = ?, hora = ?, categoria = ?, descripcion = ? WHERE id = ?'
        );
        $stmt->bind_param('sssssi', $v['titulo'], $v['fecha'], $hora, $v['categoria'], $descripcion, $id);
        $stmt->execute();

        header('Location: index.php?editado=1', true, 303);   // PRG
        exit;
    }
} else {
    // Al abrir, el formulario empieza con los datos guardados
    $v = [
        'titulo'      => $evento['titulo'],
        'fecha'       => $evento['fecha'],
        'hora'        => $evento['hora'] ? substr($evento['hora'], 0, 5) : '',   // '10:30:00' → '10:30'
        'categoria'   => $evento['categoria'],
        'descripcion' => $evento['descripcion'] ?? '',
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar evento - AgendaWeb</title>
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
                <a href="registrar.php" class="nav__link">Nuevo evento</a>
            </nav>
        </div>
    </header>

    <main class="contenedor">
        <div class="page__header">
            <div>
                <h1 class="page__title">Editar evento</h1>
                <p class="page__subtitle">Cambia los datos y guarda</p>
            </div>
            <a href="index.php" class="btn-secondary btn-sm">Cancelar</a>
        </div>

        <?php if (!empty($errores)): ?>
            <div class="alert alert--error" role="alert">⚠️ Revisa los campos marcados.</div>
        <?php endif; ?>

        <?php mostrarFormulario($v, $errores, '💾 Guardar cambios', $id); ?>
    </main>

</body>
</html>
