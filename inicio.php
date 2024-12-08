<?php
    session_start();
    require_once 'pintar-circulos.php';
    

    //Se comprueba si el usuario esta logueado 
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php");
        exit;
    }

    //Colores
    $colores = ['red','blue','yellow','green'];

    // Generar combinación aleatoria
    if (!isset($_SESSION['combinacion'])) {
        $col1 = $colores[array_rand($colores)];
        $col2 = $colores[array_rand($colores)];
        $col3 = $colores[array_rand($colores)];
        $col4 = $colores[array_rand($colores)];
        
        //Guardar combinación en la sesion
        $_SESSION['combinacion'] = [$col1, $col2, $col3, $col4];
    }else{
        // Usar la combinación almacenada en la sesión
        list($col1, $col2, $col3, $col4) = $_SESSION['combinacion'];
    }
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simón dice - Inicio</title>
</head>
<body>
    <h1>SIMÓN</h1>
    <h2>Hola <?php echo htmlspecialchars($_SESSION['usuario']); ?>, memoriza la combinación</h2>
    <?php 
    // Llamar a la función para pintar los círculos
    pintar_circulos($col1, $col2, $col3, $col4); 
    ?>
    <br>
    <form action="jugar.php" method="POST">
        <button type="submit">VAMOS A JUGAR</button>
    </form>
</body>
</html>