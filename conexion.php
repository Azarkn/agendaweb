<?php
// Configuración de conexión para DomCloud
$host = "127.0.0.1"; // Uso de IP para evitar problemas de autenticación por socket en Linux/DomCloud
$user = "prize_phone_hes";
$password = "lachilindrina666";
$database = "prize_phone_hes_agenda_web";

// Crear conexión
$mysqli = new mysqli($host, $user, $password, $database);

// Validar si ocurrió un error en la conexión
if ($mysqli->connect_error) {
    die("Error de conexión a la base de datos: " . $mysqli->connect_error);
}

// Configurar el conjunto de caracteres a UTF-8
$mysqli->set_charset("utf8mb4");
?>