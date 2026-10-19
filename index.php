<?php
require_once 'conexion.php';
require_once 'funciones.php';   // e() y la lista de categorías

$resultado = $mysqli->query(
    "SELECT id, titulo, fecha, hora, categoria, descripcion
     FROM eventos
     ORDER BY fecha ASC, hora ASC"
);
 
$eventos = [];
if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        $eventos[] = $fila;
    }
    $resultado->free();
}
$total = count($eventos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Eventos - AgendaWeb</title>
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
                <a href="index.php" class="nav__link is-active">Mis eventos</a>
                <a href="registrar.php" class="nav__link">Nuevo evento</a>
            </nav>
        </div>
    </header>
 
    <main class="contenedor">
 
        <?php if (isset($_GET['noexiste']) && $_GET['noexiste'] === '1'): ?>
            <div class="alert alert--error" role="alert">⚠️ Ese evento ya no existe.</div>
        <?php endif; ?>

        <?php if (isset($_GET['ok']) && $_GET['ok'] === '1'): ?>
            <div class="alert alert--ok" role="status">✅ Evento guardado correctamente.</div>
        <?php endif; ?>
 
        <?php if (isset($_GET['editado']) && $_GET['editado'] === '1'): ?>
            <div class="alert alert--ok" role="status">✅ Evento actualizado correctamente.</div>
        <?php endif; ?>
 
        <?php if (isset($_GET['borrado']) && $_GET['borrado'] === '1'): ?>
            <div class="alert alert--ok" role="status">🗑️ Evento eliminado.</div>
        <?php endif; ?>
 
        <div class="page__header">
            <div>
                <h1 class="page__title">Mis eventos</h1>
                <p class="page__subtitle"><?= $total ?> <?= $total === 1 ? 'evento registrado' : 'eventos registrados' ?></p>
            </div>
            <a href="registrar.php" class="btn-primary">+ Nuevo evento</a>
        </div>
 
        <?php if ($total > 0): ?>
        <section class="card-list">
            <?php foreach ($eventos as $ev):
                $dt = new DateTime($ev['fecha']);
                $fechaTxt = $dt->format('d/m/Y');
                $tieneHora = !empty($ev['hora']);
                $horaTxt = $tieneHora ? substr($ev['hora'], 0, 5) : '';
                $datetime = $ev['fecha'] . ($tieneHora ? 'T' . $horaTxt : '');
            ?>
            <article class="card">
                <span class="card__badge"><?= e(ucfirst($ev['categoria'])) ?></span>
                <h2 class="card__title"><?= e($ev['titulo']) ?></h2>
                <p class="card__meta">
                    <time datetime="<?= e($datetime) ?>"><?= e($fechaTxt) ?><?= $tieneHora ? ' · ' . e($horaTxt) : '' ?></time>
                </p>
                <?php if (!empty($ev['descripcion'])): ?>
                    <p class="card__text"><?= e($ev['descripcion']) ?></p>
                <?php endif; ?>
 
                <div class="card__actions">
                    <a href="editar.php?id=<?= (int)$ev['id'] ?>" class="btn-secondary btn-sm">Editar</a>
                    <form method="post" action="borrar.php" class="form-inline" onsubmit="return confirm('¿Seguro que quieres borrar este evento?');">
                        <input type="hidden" name="id" value="<?= (int)$ev['id'] ?>">
                        <button type="submit" class="btn-danger btn-sm">Borrar</button>
                    </form>
                </div>
            </article>
            <?php endforeach; ?>
        </section>
        <?php else: ?>
        <div class="empty-state">
            <p>Aún no tienes eventos registrados.</p>
            <a href="registrar.php" class="btn-primary">Registrar el primero</a>
        </div>
        <?php endif; ?>
 
    </main>
 
    <footer class="site-footer">
        <div class="contenedor" style="text-align: center;">AgendaWeb · Tu nombre · 2026</div>
    </footer>
 
</body>
</html>
<?php $mysqli->close(); ?>
 