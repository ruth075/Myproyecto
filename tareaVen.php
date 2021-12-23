<?php
//mostrando tareas vencidas
  require_once 'login.php';
  require_once 'home.php';
  $conexion = new mysqli($hn, $un, $pw, $db, $port);

  if ($conexion->connect_error) die ("Fatal error");

  //session_start();
  if (  isset($_SESSION['username']) )
  { 
    $username = htmlspecialchars($_SESSION['username']);
  echo <<<_END
  <center><h3>Tareas Vencidas</h3></center>
  _END;
  $query = "SELECT T.IDtarea ,T.titulo,T.descripcion,T.fecha ,T.FecVencimiento ,T.pasword, D.prioridad 
  FROM tarea T  inner join usuarios U on T.pasword=U.pasword  inner join detalle_tarea D on T.IDtarea=D.ID_tarea 
  where D.prioridad='Vencida' and U.username='$username' ORDER BY T.FecVencimiento ASC";

  $result = $conexion->query($query);
  //if($result===0) {echo "<center><b><h5>NO tienes tareas vencidas XD</h5></b></center>" ;}
  if (!$result) die ("Falló el acceso a la base de datos");
  $rows = $result->num_rows;
  echo <<<_END
  <table bordercolor="purple" BORDER CELLPADDING=10 CELLSPACING=0> ><tr> 
  _END;

  for ($j = 0; $j < $rows; $j++){

        if ($j%5==0){ // para saltar filas 
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
       <td BGCOLOR="red"><pre>
       
       <b>Titulo</b>: $r1
       <b>Descripcion</b>: $r2
       <b>Prioridad</b>: $r6
       <b>Fecha</b>: $r3
       <b>FV </b>:$r4 </pre>
       <form action='home.php' method='post'>
       <input type='hidden' name='delete' value='yes'>
       <input type='hidden' name='idtarea' value='$r0'>
       <input type='submit' value='BORRAR'></form></td>
       _END;
      }
      $result->close();
    }
    echo <<<_END
    </table>
    _END;
    $conexion->close();
?>