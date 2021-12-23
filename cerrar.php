<?php 
 //iniciamos la sesión  
session_start(); 
//sabemos que se inicio session en la parte donde verificamos el username
// y el password   
//reutilizamos la variable donde se guardo la fecha en el que el usuario inicio session
if ( isset($_SESSION["ultimoAcceso"])){
    $fechaGuardada = $_SESSION["ultimoAcceso"];
    $ahora = time();
    $caduca = $ahora-$fechaGuardada;
     if($caduca >= 24*60*60) {
     //si pasaron 1 dia o más
      session_destroy(); // destruyo la sesión
      header("Location: signin.php"); //envío al usuario a la pag. de autenticación
    }else {
    $_SESSION["ultimoAcceso"] = $ahora; // de lo contrario se actualiza la variable de fecha 
   }
 }
?>