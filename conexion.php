<?php
$host = "localhost";
$user = "prize-phone-hes";
$password = "lachilindrina666";
$database = "prize_phone_hes_agendadb";

$mysqli = new mysqli($host, $user, $password, $database);

if ($mysqli->connect_error) {
    die("Error de conexión a la base de datos: " . $mysqli->connect_error);
}

$mysqli->set_charset("utf8mb4");
?>