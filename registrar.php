<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo      = trim($_POST['titulo']      ?? '');
    $fecha       = trim($_POST['fecha']       ?? '');
    $hora        = trim($_POST['hora']        ?? '');
    $categoria   = trim($_POST['categoria']   ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
 
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
    <link rel="stylesheet" href="estilos.css">
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
 
        <form method="post" action="" class="form-card">
 
            <div class="campo">
                <label for="titulo">Título del evento</label>
                <input type="text" id="titulo" name="titulo" maxlength="120" required>
            </div>
 
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" name="fecha" required>
            </div>
 
            <div class="campo">
                <label for="hora">Hora (opcional)</label>
                <input type="time" id="hora" name="hora">
            </div>
 
            <div class="campo">
                <label for="categoria">Categoría</label>
                <select id="categoria" name="categoria" required>
                    <option value="">Selecciona una categoría</option>
                    <option value="trabajo">💼 Trabajo</option>
                    <option value="personal">👤 Personal</option>
                    <option value="estudio">📚 Estudio</option>
                    <option value="ocio">🎮 Ocio</option>
                </select>
            </div>
 
            <div class="campo">
                <label for="descripcion">Descripción (opcional)</label>
                <textarea id="descripcion" name="descripcion" maxlength="500"></textarea>
            </div>
 
            <button type="submit" class="btn-primary">💾 Guardar</button>
        </form>
    </main>
 
</body>
</html>
 