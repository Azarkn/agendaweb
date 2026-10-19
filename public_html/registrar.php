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

        <!-- Formulario de Registro -->
        <article class="tarjeta">
            <form action="index.php" method="GET">
                
                <div class="grupo-input">
                    <label for="titulo">Título del evento</label>
                    <input type="text" id="titulo" name="titulo" placeholder="Ej. Reunión de trabajo" required>
                </div>

                <div class="grupo-input">
                    <label for="categoria">Categoría</label>
                    <input type="text" id="categoria" name="categoria" placeholder="Ej. Trabajo, Personal, Recordatorio">
                </div>

                <div class="grupo-input">
                    <label for="fecha">Fecha y hora</label>
                    <input type="datetime-local" id="fecha" name="fecha">
                </div>

                <div class="grupo-input">
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion" rows="4" placeholder="Detalles adicionales del evento..."></textarea>
                </div>

                <button type="submit" class="btn-principal">Guardar evento</button>

            </form>
        </article>

    </main>

    <!-- Pie de página -->
    <footer class="site-footer">
        <div class="contenedor" style="text-align: center;">AgendaWeb · Erik M. · 2026</div>
    </footer>

</body>
</html>