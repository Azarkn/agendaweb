<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Panel de Diagnóstico de Registro</h1>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<p style='color:blue;'>-> El servidor recibió una petición POST.</p>";
    
    echo "<pre>Datos $_POST recibidos: <br>";
    print_r($_POST);
    echo "</pre>";

    require 'conexion.php';
    echo "<p style='color:green;'>-> Conexión a la base de datos incluida correctamente.</p>";

    $titulo      = $_POST['titulo']      ?? '';
    $fecha_hora  = $_POST['fecha']       ?? '';
    $categoria   = $_POST['categoria']   ?? '';
    $descripcion = $_POST['descripcion'] ?? '';

    // Separar fecha y hora
    $fecha = '';
    $hora = null;
    if (!empty($fecha_hora)) {
        $partes = explode('T', $fecha_hora);
        $fecha = $partes[0] ?? '';
        $hora = ($partes[1] ?? '') . ':00';
    }

    $sql = "INSERT INTO eventos (titulo, fecha, hora, categoria, descripcion) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssss", $titulo, $fecha, $hora, $categoria, $descripcion);
        if ($stmt->execute()) {
            echo "<h3 style='color:green;'>¡ÉXITO! El evento se insertó correctamente en la base de datos.</h3>";
        } else {
            echo "<h3 style='color:red;'>Error al ejecutar la consulta: " . $stmt->error . "</h3>";
        }
        $stmt->close();
    } else {
        echo "<h3 style='color:red;'>Error al preparar la consulta: " . $mysqli->error . "</h3>";
    }
    
    $mysqli->close();
    echo "<br><a href='registrar.php'>Volver al formulario</a>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Diagnóstico</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body style="padding: 20px;">
    <h2>Formulario de Prueba</h2>
    <form action="registrar.php" method="POST">
        <p>Título: <input type="text" name="titulo" value="Evento de prueba" required></p>
        <p>Categoría: <input type="text" name="categoria" value="Trabajo" required></p>
        <p>Fecha y hora: <input type="datetime-local" name="fecha" required></p>
        <p>Descripción: <textarea name="descripcion">Probando inserción</textarea></p>
        <button type="submit">Enviar prueba</button>
    </form>
</body>
</html>