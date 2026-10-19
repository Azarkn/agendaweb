<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Eventos - AgendaWeb</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <!-- Estilos CSS -->
    <link rel="stylesheet" href="estilos.css">
</head>
<body class="layout">

    <!-- Encabezado de la página -->
    <header class="site-header">
        <div class="contenedor site-header__inner">
            <a href="index.php" class="logo">Agenda<span>Web</span></a>
            <nav class="nav">
                <a href="index.php" class="nav__link is-active">Mis eventos</a>
                <a href="registrar.php" class="nav__link">Nuevo evento</a>
            </nav>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="contenedor">
        
        <!-- Aviso de éxito (En P4 aparecerá con ?ok=1) -->
        <div class="alert alert--ok" role="status">✅ Evento guardado correctamente.</div>

        <div class="page__header">
            <div>
                <h1 class="page__title">Mis eventos</h1>
                <p class="page__subtitle">3 eventos registrados</p>
            </div>
            <a href="registrar.php" class="btn-primary">+ Nuevo evento</a>
        </div>

        <!-- Rejilla de Tarjetas de Eventos -->
        <section class="card-list">

            <!-- ▼ INICIO de evento 1 (Completo) -->
            <article class="card">
                <span class="card__badge">Trabajo</span>
                <h2 class="card__title">Reunión de academia</h2>
                <p class="card__meta">
                    <time datetime="2026-09-25T10:30">25/09/2026 · 10:30</time>
                </p>
                <p class="card__text">Revisar calificaciones del 1er parcial.</p>

                <div class="card__actions">
                    <a href="editar.php?id=1" class="btn-secondary btn-sm">Editar</a>
                    <form method="post" action="borrar.php" class="form-inline">
                        <input type="hidden" name="id" value="1">
                        <button type="submit" class="btn-danger btn-sm">Borrar</button>
                    </form>
                </div>
            </article>
            <!-- ▲ FIN de evento 1 -->

            <!-- ▼ INICIO de evento 2 (Sin descripción) -->
            <article class="card">
                <span class="card__badge">Personal</span>
                <h2 class="card__title">Cita médica con el dentista</h2>
                <p class="card__meta">
                    <time datetime="2026-09-27T16:00">27/09/2026 · 16:00</time>
                </p>

                <div class="card__actions">
                    <a href="editar.php?id=2" class="btn-secondary btn-sm">Editar</a>
                    <form method="post" action="borrar.php" class="form-inline">
                        <input type="hidden" name="id" value="2">
                        <button type="submit" class="btn-danger btn-sm">Borrar</button>
                    </form>
                </div>
            </article>
            <!-- ▲ FIN de evento 2 -->

            <!-- ▼ INICIO de evento 3 (Título largo y sin hora específica) -->
            <article class="card">
                <span class="card__badge">Recordatorio</span>
                <h2 class="card__title">Entrega de proyecto final de Desarrollo de Aplicaciones Web</h2>
                <p class="card__meta">
                    <time datetime="2026-09-30">30/09/2026</time>
                </p>
                <p class="card__text">Subir enlaces a la plataforma escolar.</p>

                <div class="card__actions">
                    <a href="editar.php?id=3" class="btn-secondary btn-sm">Editar</a>
                    <form method="post" action="borrar.php" class="form-inline">
                        <input type="hidden" name="id" value="3">
                        <button type="submit" class="btn-danger btn-sm">Borrar</button>
                    </form>
                </div>
            </article>
            <!-- ▲ FIN de evento 3 -->

        </section>

        <!-- Estado vacío (En P4 aparecerá solo si no hay eventos) -->
        <div class="empty-state" style="display: none;">
            <p>Aún no tienes eventos registrados.</p>
            <a href="registrar.php" class="btn-primary">Registrar el primero</a>
        </div>

    </main>

    <!-- Pie de página -->
    <footer class="site-footer">
        <div class="contenedor" style="text-align: center;">AgendaWeb · Tu nombre · 2026</div>
    </footer>

</body>
</html>