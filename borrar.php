<?php
// borrar.php · elimina un evento. Solo acepta POST (el botón "Borrar" de la lista),
// así una visita o un enlace no pueden borrar nada.
require_once 'conexion.php';
require_once 'funciones.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php', true, 303);
    exit;
}

$id = $_POST['id'] ?? '';
$id = is_string($id) && ctype_digit($id) ? (int) $id : 0;   // el id solo puede ser un número

$stmt = $mysqli->prepare('DELETE FROM eventos WHERE id = ?');   // WHERE: borra SOLO ese evento
$stmt->bind_param('i', $id);
$stmt->execute();

// affected_rows = cuántas filas se borraron (0 = ese evento ya no existía)
if ($stmt->affected_rows > 0) {
    header('Location: index.php?borrado=1', true, 303);   // PRG
} else {
    header('Location: index.php?noexiste=1', true, 303);
}
exit;
