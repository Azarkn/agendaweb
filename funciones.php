<?php
// funciones.php · lo que comparten registrar.php, editar.php, borrar.php e index.php

// Si una consulta falla, se muestra un mensaje sencillo en lugar de un error de PHP
set_exception_handler(function (Throwable $e): void {
    error_log('AgendaWeb: ' . $e->getMessage());
    http_response_code(500);
    echo 'Ocurrió un error con la base de datos. Intenta de nuevo.';
});

// Escapa un texto antes de mostrarlo en el HTML (así nunca se ejecuta como código)
function e($v): string
{
    return htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Lista blanca: las únicas categorías que se aceptan (valor => texto del menú)
const CATEGORIAS = [
    'trabajo'  => '💼 Trabajo',
    'personal' => '👤 Personal',
    'estudio'  => '📚 Estudio',
    'ocio'     => '🎮 Ocio',
];

// Cuántas letras tiene un texto (strlen cuenta bytes: "á" valdría 2)
function largo(string $texto): int
{
    return preg_match_all('/./us', $texto);
}

// Lo que llegó del formulario (POST), sin espacios de sobra
function leerFormulario(): array
{
    $valores = [];
    foreach (['titulo', 'fecha', 'hora', 'categoria', 'descripcion'] as $campo) {
        $dato = $_POST[$campo] ?? '';
        $valores[$campo] = is_string($dato) ? trim($dato) : '';
    }
    return $valores;
}

// Validación en el servidor. Devuelve campo => mensaje (si está vacío, todo está bien)
function validarEvento(array $v): array
{
    $errores = [];

    // Los textos deben llegar en UTF-8 (un navegador siempre los manda así)
    foreach (['titulo', 'descripcion'] as $campo) {
        if (!preg_match('//u', $v[$campo])) {
            $errores[$campo] = 'El texto tiene caracteres no válidos.';
        }
    }

    if (!isset($errores['titulo'])) {
        if ($v['titulo'] === '') {
            $errores['titulo'] = 'El título es obligatorio.';
        } elseif (largo($v['titulo']) > 120) {
            $errores['titulo'] = 'El título no puede superar los 120 caracteres.';
        }
    }

    $fecha = DateTime::createFromFormat('!Y-m-d', $v['fecha']);
    if (!$fecha || $fecha->format('Y-m-d') !== $v['fecha']) {
        $errores['fecha'] = $v['fecha'] === '' ? 'La fecha es obligatoria.' : 'La fecha no es válida.';
    }

    if ($v['hora'] !== '' && !preg_match('/^([01]\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/', $v['hora'])) {
        $errores['hora'] = 'La hora no es válida.';
    }

    if (!array_key_exists($v['categoria'], CATEGORIAS)) {
        $errores['categoria'] = 'Elige una categoría válida.';
    }

    if (!isset($errores['descripcion']) && largo($v['descripcion']) > 500) {
        $errores['descripcion'] = 'La descripción no puede superar los 500 caracteres.';
    }

    return $errores;
}

// Mensaje de error debajo de un campo (si lo tiene)
function mensajeError(array $errores, string $campo): string
{
    return isset($errores[$campo]) ? '<span class="error-text">' . e($errores[$campo]) . '</span>' : '';
}

// El formulario de registrar.php y editar.php. Es "pegajoso": si hay errores,
// vuelve a mostrar lo que la persona escribió. $id solo se pasa al editar.
function mostrarFormulario(array $v, array $errores, string $textoBoton, ?int $id = null): void
{
    ?>
        <form method="post" action="<?= $id === null ? 'registrar.php' : 'editar.php' ?>" class="form-card">
            <?php if ($id !== null): ?>
                <input type="hidden" name="id" value="<?= $id ?>">
            <?php endif; ?>

            <div class="campo">
                <label for="titulo">Título del evento</label>
                <input type="text" id="titulo" name="titulo" maxlength="120" required value="<?= e($v['titulo']) ?>">
                <?= mensajeError($errores, 'titulo') ?>
            </div>

            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" name="fecha" required value="<?= e($v['fecha']) ?>">
                <?= mensajeError($errores, 'fecha') ?>
            </div>

            <div class="campo">
                <label for="hora">Hora (opcional)</label>
                <input type="time" id="hora" name="hora" value="<?= e($v['hora']) ?>">
                <?= mensajeError($errores, 'hora') ?>
            </div>

            <div class="campo">
                <label for="categoria">Categoría</label>
                <select id="categoria" name="categoria" required>
                    <option value="">Selecciona una categoría</option>
                    <?php foreach (CATEGORIAS as $valor => $texto): ?>
                        <option value="<?= e($valor) ?>"<?= $v['categoria'] === $valor ? ' selected' : '' ?>><?= e($texto) ?></option>
                    <?php endforeach; ?>
                </select>
                <?= mensajeError($errores, 'categoria') ?>
            </div>

            <div class="campo">
                <label for="descripcion">Descripción (opcional)</label>
                <textarea id="descripcion" name="descripcion" maxlength="500"><?= e($v['descripcion']) ?></textarea>
                <?= mensajeError($errores, 'descripcion') ?>
            </div>

            <button type="submit" class="btn-primary"><?= e($textoBoton) ?></button>
        </form>
    <?php
}
