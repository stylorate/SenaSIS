<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.css">
		<link rel="stylesheet" type="text/css" href="estilos/estilos.css">
	<title>Sesion *|* Crowned</title>
</head>
<body background="images/bg0.jpg" style="background-attachment: fixed" >


<?php
$conexion = mysqli_connect("localhost","root","","pruebas");

if (!$conexion) {
 die("Error de conexión (".mysqli_connect_errno().")".mysqli_connect_error());
} 
?>

<?php


$usuario=$_POST["usuario"];
$password=$_POST["password"];
 

$cliente = mysql_query("SELECT * FROM cliente WHERE cliente = '$usuario' AND password = '$password'");
$empleado = mysql_query("SELECT * FROM empleado WHERE empleado = '$usuario' AND password = '$password'");
$administrador = mysql_query("SELECT * FROM administrador WHERE administrador = '$usuario' AND password = '$password'");
 

 

if(mysqli_stmt_num_rows($cliente) > 0) 
{

    session_start();
 
    $_SESSION['cliente']="$usuario";
 
    header("index2.php");
     exit(); 
}

else if(mysqli_stmt_num_rows($empleado) > 0) 
{
    session_start();
    $_SESSION['empleado']="$usuario";
    header("Location: entrenador/espacioentrenador.php");
    exit(); 
}

else if(mysqli_stmt_num_rows($administrador) > 0) 
{
    session_start();
    $_SESSION['administrador']="$usuario";
    header("www.google.com");
    exit();
} 
else 
{
 
   $mensajeaccesoincorrecto = "El usuario y la contraseña son incorrectos, por favor vuelva a introducirlos.";
   echo $mensajeaccesoincorrecto; 
} ?>
	
</body>
</html>