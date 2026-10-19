<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mysqli = new mysqli("localhost", "prize_phone_hes", "EvUi2yY+Y)X26a45f-", "prize_phone_hes_agenda_web");

if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

$mysqli->set_charset("utf8mb4");
?>