<?php
session_start();
require_once 'pintar-circulos.php';

// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'bdsimon');
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

// Consulta para buscar el código de usuario
$sql = "SELECT Codigo FROM usuarios WHERE Nombre = ?";
$consulta = $conexion->prepare($sql);

if (!$consulta) {
    die("Error en la consulta SQL: " . $conexion->error);
}

// Preparar la consulta
$consulta->bind_param("s", $_SESSION['usuario']);
$consulta->execute();
$resultado = $consulta->get_result();

// Validar si el usuario existe
if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_object();
    $cod_usuario = $usuario->Codigo;
} else {
    die("Usuario no encontrado en la base de datos.");
}

// Validar combinación generada y comparar con la combinación del usuario
$acierto = (isset($_SESSION['combinacion']) && isset($_SESSION['jugada_usuario']) && $_SESSION['combinacion'] === $_SESSION['jugada_usuario']);

if ($acierto) {
    // Insertar en la base de datos la información de que el usuario acertó
    $query_insert = "INSERT INTO jugadas (codigousu, acierto) VALUES (?, 1)";
    $stmt_insert = $conexion->prepare($query_insert);

    if ($stmt_insert) {
        $stmt_insert->bind_param('i', $cod_usuario);
        $stmt_insert->execute();
        $stmt_insert->close();
    } else {
        die("Error al preparar la consulta de inserción.");
    }
}
session_destroy();
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acierto</title>
</head>
<body>
    <h1>¡Felicidades, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h1>
    
    <?php if ($acierto): ?>
        <h2>¡Has acertado la combinación!</h2>
        <?php 
            // Llamar a la función para pintar la combinación que acertó el usuario
            pintar_circulos($_SESSION['combinacion'][0], $_SESSION['combinacion'][1], $_SESSION['combinacion'][2], $_SESSION['combinacion'][3]); 
        ?>
    <?php else: ?>
        <h2>Lo intentaste, pero no fue la combinación correcta.</h2>
    <?php endif; ?>
</body>
</html>
