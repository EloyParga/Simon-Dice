<?php
    session_start();
    require_once 'pintar-circulos.php';

    // Verificar si el usuario está logueado
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php");
        exit;
    }

    // Iniciar varibale jugada si no existe
    if(!isset($_SESSION['jugada_usuario'])){
        $_SESSION['jugada_usuario'] = [];
    }

    // Función para pintar los cuatro círculos en color negro
    function pintar_circulos_usuario($jugada_usuario) {
        $colores = ['black','black','black','black']; //Circulos por defecto;
        for($i=0; $i < count($jugada_usuario); $i++){
            $colores[$i] = $jugada_usuario[$i];
        }
        pintar_circulos($colores[0], $colores[1], $colores[2], $colores[3]);
    }

    //logica pulsaciones del botón
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['color'])) {
        $color_pulsado = $_POST['color'];

        //Guardar el color pulsado en la secuencia de jugada
        $_SESSION['jugada_usuario'][] = $color_pulsado;

        // Si se completaron las cuatro pulsaciones
        if (count($_SESSION['jugada_usuario'])=== 4 ) {
            $acierto = ($_SESSION['combinacion'] === $_SESSION['jugada_usuario']);
            if ($acierto) {
                header("Location: acierto.php");
            }else{
                header("Location: fallo.php");
                exit;
            }
        }
    }

    

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simón dice - Juego</title>
</head>
<body>
    <h1>SIMÓN</h1>
    <h2>Hola <?php echo htmlspecialchars($_SESSION['usuario']); ?>, pulsa los botones en el orden correspondiente</h2>

    <!-- Pintar los círculos negros -->
    <?php pintar_circulos_usuario($_SESSION['jugada_usuario']); ?>

    <br>
    <h3>Haz clic en los botones para registrar tu secuencia:</h3>

    <!-- Botones para el juego -->
    <form action="jugar.php" method="POST">
        <button type="submit" name="color" value="red" style="background-color: red; color: white; padding: 10px;">ROJO</button>
        <button type="submit" name="color" value="blue" style="background-color: blue; color: white; padding: 10px;">AZUL</button>
        <button type="submit" name="color" value="yellow" style="background-color: yellow; color: black; padding: 10px;">AMARILLO</button>
        <button type="submit" name="color" value="green" style="background-color: green; color: white; padding: 10px;">VERDE</button>
    </form>
</body>
</html>