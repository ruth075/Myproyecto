<?php
  require_once 'login.php';
  require_once 'home.php';
  $conexion = new mysqli($hn, $un, $pw, $db, $port);

  if ($conexion->connect_error) die ("Fatal error");

  $query = "SELECT IDtarea FROM tarea  ";
  $result = $conexion->query($query);
  if (!$result) die ("Falló el acceso a la base de datos");
  $rows = $result->num_rows;

  for ($j = 0; $j < $rows; $j++)
  {
      $row = $result->fetch_array(MYSQLI_NUM);
      $r0 = htmlspecialchars($row[0]);
      // si hubo presencia en el boton archivar se hara una actualizacion de estado de la tarea 
      if (isset($_POST['id']) && isset($_POST['archivar']))
      {  
         $id= get_post($conexion,'id'); // funcion declarada en archivo 'home.php'
         if($r0===$id){
            $query = " UPDATE detalle_tarea SET prioridad='Archivado' WHERE ID_tarea='$r0' "; 
            $result1 = $conexion->query($query);
            if (!$result1) echo "ALGO FALLO "; 
            echo ("<br><br><center><b>SE ARCHIVO CORRECTAMENTE </b><center>");
         }
      }
  }
     $result->close();
     $conexion->close();

    
?>