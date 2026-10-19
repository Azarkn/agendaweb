<?php
// Incluimos la conexión limpia
require_once 'conexion.php';

echo "<h1>Panel de Diagnóstico de Registro</h1>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<p style='color: blue;'>-> El servidor recibió una petición POST.</p>";

    // Recepción de variables desde el formulario
    $titulo      = isset($_POST['titulo']) ? $_POST['titulo'] : '';
    $categoria   = isset($_POST['categoria']) ? $_POST['categoria'] : '';
    $fecha       = isset($_POST['fecha']) ? $_POST['fecha'] : '';
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';

    echo "<strong>Datos recibidos:</strong><br>";
    echo "<pre>";
    print_r([
        'titulo'      => $titulo,
        'categoria'   => $categoria,
        'fecha'       => $fecha,
        'descripcion' => $descripcion
    ]);
    echo "</pre>";

    // Inserción en la base de datos
    $sql = "INSERT INTO eventos (titulo, categoria, fecha, descripcion) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssss", $titulo, $categoria, $fecha, $descripcion);

        if ($stmt->execute()) {
            echo "<h2 style='color: green;'>¡Evento guardado con éxito en la base de datos!</h2>";
            echo "<p><a href='index.php'>Volver al formulario</a></p>";
        } else {
            echo "<p style='color: red;'>Error al ejecutar la inserción: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p style='color: red;'>Error en la preparación de la consulta: " . $mysqli->error . "</p>";
    }

    $mysqli->close();

} else {
    echo "<p style='color: red;'>No se recibió ninguna petición POST. Envía los datos desde el formulario.</p>";
}
?>