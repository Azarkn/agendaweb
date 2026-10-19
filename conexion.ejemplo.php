<?php
// conexion.ejemplo.php · PLANTILLA (esta sí se sube a GitHub)
// 1. Cópiala como conexion.php y pon tus datos reales (en tu compu: root y tu contraseña de MySQL).
// 2. En DomCloud no hace falta: la receta crea conexion.php con los datos del servidor.
// 3. conexion.php NUNCA se sube a GitHub (ver .gitignore).

// Desde PHP 8.1, si algo falla, mysqli lanza una excepción que podemos atrapar
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $mysqli = new mysqli("localhost", "USUARIO", "CONTRASEÑA", "agenda");
    $mysqli->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    error_log('AgendaWeb: ' . $e->getMessage());
    die("No se pudo conectar a la base de datos.");
}
