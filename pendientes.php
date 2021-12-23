<?php
  require_once 'login.php';
  require_once 'home.php';
  $conexion = new mysqli($hn, $un, $pw, $db, $port);

  if ($conexion->connect_error) die ("Fatal error");

  //session_start();
  if (  isset($_SESSION['username']) )
  { 
    $username = htmlspecialchars($_SESSION['username']);
  echo <<<_END
  <center><h3>Todas las tareas pendientes </h3></center>
  _END;
  $query = "SELECT T.IDtarea ,T.titulo,T.descripcion,T.fecha ,T.FecVencimiento ,T.pasword, D.prioridad 
  FROM tarea T  inner join usuarios U on T.pasword=U.pasword  inner join detalle_tarea D on T.IDtarea=D.ID_tarea 
  where   U.username='$username'and D.prioridad != 'Archivado' and D.prioridad != 'Vencida'
  ORDER BY T.FecVencimiento ASC";

  $result = $conexion->query($query); 
  if (!$result) die ("Algo fallo :/");
  $rows = $result->num_rows;
  echo <<<_END
  <table border="1" bordercolor="Green"><tr> 
  _END;

  for ($j = 0; $j < $rows; $j++){
    if ($j%4==0){
      echo "</tr>";}

    $row = $result->fetch_array(MYSQLI_NUM);
    $r0 = htmlspecialchars($row[0]);
    $r1 = htmlspecialchars($row[1]);
    $r2 = htmlspecialchars($row[2]);
    $r3 = htmlspecialchars($row[3]);
    $r4 = htmlspecialchars($row[4]);
    $r5 = htmlspecialchars($row[5]);
    $r6 = htmlspecialchars($row[6]);
    echo <<<_END
    <td BGCOLOR="white">
    <pre>
    
    <b>Titulo</b>: $r1
    <b>Descripcion</b>: $r2
    <b>Prioridad</b>: $r6
    <b>Fecha</b>: $r3
    <b>FV </b>:$r4
    </pre>
    <form action='home.php' method='post'>
    <input type='hidden' name='delete' value='yes'>
    <input type='hidden' name='idtarea' value='$r0'>
    <table><tr><input type='submit' value='BORRAR'></tr></form>
    _END;
  // viendo el tiempo de caducidad
     date_default_timezone_set('America/lima');
     $fechaActual= strtotime(date("d-m-Y H:i:00",time()));
     $fven=strtotime($r4);
     if ($fechaActual<$fven)
     {
        echo <<<_END
       
        <form action="actual.php" method="post"></ol>
        <input type='hidden' name='nuevo' value='yes'>
        <input type='hidden' name='idtareas' value='$r0'>
        <tr><input type='submit' value='ACTUALIZAR'></tr>
        </form> <tr>
        _END; 
        echo <<<_END
      
        <form action="archivar.php" method="post">
        <input type='hidden' name='archivar' value='yes'>
        <input type='hidden' name='id' value='$r0'>
        <tr><input type='submit' value='ARCHIVAR'></tr></table>
        </form> </td>
        _END; 

     } else 
        {
         echo (" VENCIDA");
          $query = " UPDATE detalle_tarea SET prioridad='Vencida' WHERE ID_tarea='$r0' "; 
          $result1 = $conexion->query($query);
         if (!$result1) echo "ALGO FALLO ";
        }  

      }
      echo <<<_END
      </table > 
      _END;
      $result->close();
    }

     $conexion->close();
?>