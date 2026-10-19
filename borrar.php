<?php

require_once 'conexion.php';
require_once 'funciones.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php', true, 303);
    exit;
}

$id = $_POST['id'] ?? '';
$id = is_string($id) && ctype_digit($id) ? (int) $id : 0;   

$stmt = $mysqli->prepare('DELETE FROM eventos WHERE id = ?');  
$stmt->bind_param('i', $id);
$stmt->execute();


if ($stmt->affected_rows > 0) {
    header('Location: index.php?borrado=1', true, 303);   
} else {
    header('Location: index.php?noexiste=1', true, 303);
}
exit;
