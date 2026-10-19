<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$titulo = '';
$fecha = '';
$hora = '';
$categoria = '';
$descripcion = '';
$errores = [];
$categoriasOK = ['trabajo', 'personal', 'estudio', 'ocio', 'recordatorio'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo      = trim($_POST['titulo']      ?? '');
    $fecha_hora  = trim($_POST['fecha']       ?? ''); 
    $categoria   = trim($_POST['categoria']   ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');

    // Separar fecha y hora si se ingresaron juntas
    $fecha = '';
    $hora = null;
    if (!empty($fecha_hora)) {
        $partes = explode('T', $fecha_hora);
        $fecha = $partes[0] ?? '';
        $hora = $partes[1] ?? null;
        if ($hora) {
            $hora = $hora . ':00'; // Asegurar formato HH:MM:SS
        }
    }

    // Validación del Servidor
    if ($titulo === '') {
        $errores['titulo'] = 'El título es obligatorio.';
    } elseif (mb_strlen($titulo) > 120) {
        $errores['titulo'] = 'Máximo 120 caracteres.';
    }

    if ($fecha === '') {
        $errores['fecha'] = 'La fecha es obligatoria.';
    }

    if ($categoria === '') {
        $errores['categoria'] = 'La categoría es obligatoria.';
    }

    // Si no hay errores, guardamos en la base de datos con consulta preparada
    if (empty($errores)) {
        require 'conexion.php';

        $sql = "INSERT INTO eventos (titulo, fecha, hora, categoria, descripcion) VALUES (?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("sssss", $titulo, $fecha, $hora, $categoria, $descripcion);
            $stmt->execute();
            $stmt->close();
            $mysqli->close();

            // Patrón PRG (Post / Redirect / Get) para evitar duplicados y mostrar éxito
            header('Location: index.php?ok=1');
            exit;
        } else {
            $errores['general'] = 'Error en la preparación de la consulta: ' . $mysqli->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Evento - AgendaWeb</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <!-- Estilos CSS -->
    <link rel="stylesheet" href="estilos.css">
</head>
<body class="layout">

    <!-- Encabezado del sitio -->
    <header class="site-header">
        <div class="contenedor site-header__inner">
            <a href="index.php" class="logo">Agenda<span>Web</span></a>
            <nav class="nav">
                <a href="index.php" class="nav__link">Mis eventos</a>
                <a href="registrar.php" class="nav__link is-active">Nuevo evento</a>
            </nav>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="contenedor">
        
        <div class="page__header">
            <div>
                <h1 class="page__title">Registrar nuevo evento</h1>
                <p class="page__subtitle">Completa los datos para agendar una actividad</p>
            </div>
        </div>

        <?php if (isset($errores['general'])): ?>
            <div class="alert" style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                <?= $errores['general'] ?>
            </div>
        <?php endif; ?>

        <!-- Formulario de Registro con POST -->
        <article class="tarjeta" style="background: var(--superficie); padding: 20px; border-radius: 12px; border: 1px solid var(--borde);">
            <form action="registrar.php" method="POST">
                
                <div class="grupo-input" style="margin-bottom: 15px;">
                    <label for="titulo" style="display: block; margin-bottom: 5px; font-weight: 500;">Título del evento</label>
                    <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') ?>" placeholder="Ej. Reunión de trabajo" required style="width: 100%; padding: 8px; border: 1px solid var(--borde); border-radius: 6px;">
                    <?php if (isset($errores['titulo'])): ?>
                        <span class="error" style="color: #b42318; font-size: 0.85rem;"><?= $errores['titulo'] ?></span>
                    <?php endif; ?>
                </div>

                <div class="grupo-input" style="margin-bottom: 15px;">
                    <label for="categoria" style="display: block; margin-bottom: 5px; font-weight: 500;">Categoría</label>
                    <input type="text" id="categoria" name="categoria" value="<?= htmlspecialchars($categoria, ENT_QUOTES, 'UTF-8') ?>" placeholder="Ej. Trabajo, Personal, Recordatorio" required style="width: 100%; padding: 8px; border: 1px solid var(--borde); border-radius: 6px;">
                    <?php if (isset($errores['categoria'])): ?>
                        <span class="error" style="color: #b42318; font-size: 0.85rem;"><?= $errores['categoria'] ?></span>
                    <?php endif; ?>
                </div>

                <div class="grupo-input" style="margin-bottom: 15px;">
                    <label for="fecha" style="display: block; margin-bottom: 5px; font-weight: 500;">Fecha y hora</label>
                    <input type="datetime-local" id="fecha" name="fecha" value="<?= htmlspecialchars($fecha_hora ?? '', ENT_QUOTES, 'UTF-8') ?>" required style="width: 100%; padding: 8px; border: 1px solid var(--borde); border-radius: 6px;">
                    <?php if (isset($errores['fecha'])): ?>
                        <span class="error" style="color: #b42318; font-size: 0.85rem;"><?= $errores['fecha'] ?></span>
                    <?php endif; ?>
                </div>

                <div class="grupo-input" style="margin-bottom: 20px;">
                    <label for="descripcion" style="display: block; margin-bottom: 5px; font-weight: 500;">Descripción</label>
                    <textarea id="descripcion" name="descripcion" rows="4" placeholder="Detalles adicionales del evento..." style="width: 100%; padding: 8px; border: 1px solid var(--borde); border-radius: 6px;"><?= htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>

                <button type="submit" class="btn-primary">Guardar evento</button>

            </form>
        </article>

    </main>

    <!-- Pie de página -->
    <footer class="site-footer">
        <div class="contenedor" style="text-align: center;">AgendaWeb · Erik M. · 2026</div>
    </footer>

</body>
</html>