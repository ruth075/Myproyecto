<?php
// la actualizacion de datos una vez llenado el boton de ACTUALIZAR
 // se debe actualizar la pagina para ver el cambio nuevo
  require_once 'login.php';
  require_once 'home.php';
  $conexion = new mysqli($hn, $un, $pw, $db, $port);

  if ($conexion->connect_error) die ("Fatal error");
//realizando una consulta 
  $query = "SELECT IDtarea,titulo,descripcion,FecVencimiento FROM tarea  ";
  $result = $conexion->query($query);
  if (!$result) die ("Falló el acceso a la base de datos");
  $rows = $result->num_rows; //fils

  for ($j = 0; $j < $rows; $j++)
  {
      $row = $result->fetch_array(MYSQLI_NUM);
      $r0 = htmlspecialchars($row[0]);
      if (isset($_POST['idtareas']) && isset($_POST['nuevo']))
      {  
         $idtareas= get_post($conexion, 'idtareas');
         if($r0===$idtareas){
            //echo (" Datos iguales"); si los password son iguales
            echo <<<_END
            <h1>Nuevos Datos</h1>
            <form action="actual.php" method="post"><pre>
                Detalle  <input type="text" name="detalles"required>
                F-V      <input type="date" name="vencimientos" required><input type="time" name="hora" required>
                         <input type="hidden" name="idtareas1" value='$idtareas'> 
                         <input type="submit" value="Enviar">
            </pre></form>
            _END;  
         }
      }
  }
  // si se lleno el formulario procedera hacer uana actualizacion 
  if (isset($_POST['detalles']) && isset($_POST['vencimientos']) && isset($_POST['idtareas1'])){
        $detalle1 = get_post($conexion, 'detalles');
        $idtareas1= get_post($conexion, 'idtareas1');

        $vencimientos = get_post($conexion, 'vencimientos');
        $hora1 = get_post($conexion, 'hora');
        $vencimiento1 = "$vencimientos"." "."$hora1"; // fecha concatenada
        $query = " UPDATE tarea SET descripcion='$detalle1' WHERE Idtarea='$idtareas1' "; 
        $result = $conexion->query($query);
        $query = " UPDATE tarea SET fecVencimiento='$vencimiento1' WHERE IDtarea='$idtareas1' "; 
        $result = $conexion->query($query);
        echo ("<br><br><center><b>SE ACTUALIZO LOS DATOS CORRECTAMENTE </b><center>"); 
        
        if (!$result) echo "ALGO FALLO ";
       
     
    }  
    // $result->close();
     $conexion->close();

   
?>