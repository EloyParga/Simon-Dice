<?php
session_start();
$mensaje="";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $usuario = trim($_POST['usuario']);
    $clave = trim($_POST['clave']);

    // Conexion con la bd

    $conn = new mysqli("localhost", "root", "", "bdsimon");
    if($conn->connect_error){
        die("Error de conexion: ".$conn->connect_error);
    }

    // Consulta para verificar usu y pass

    $sql="SELECT Nombre, Clave FROM usuarios WHERE Nombre = ? AND Clave= ?";
    $consulta = $conn->prepare($sql);

    if($consulta === false){
        die("Error en la consulta SQL: ". $conn->error);
    }

    $consulta->bind_param("ss", $usuario, $clave);
    $consulta->execute();
    $result = $consulta->get_result();

    if ($result->num_rows>0) {
           $_SESSION['usuario'] =$usuario;
           header("Location: inicio.php");
           exit;
    }else{
        $mensaje = " Usuario o Contraseña incorrectos";
    }
    $consulta->close();
    $conn->close();


    
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simon Dice - Inicio de sesion</title>
</head>
<body>
    <h1> VAMOS A JUGAR AL SIMON!!!!</h1>
    <form action="index.php" method="post">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" required>
        <br><br>
        <label for="clave">Clave:</label>
        <input type="text" name="clave" id="clave" required>
        <br><br>
        <button type="submit">Entrar</button>
    </form>

    <p style="color: red;"><?php echo $mensaje?></p>

</body>
</html>