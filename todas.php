<?php
//mostrando todas las tareas
  require_once 'login.php';
  require_once 'home.php';
  $conexion = new mysqli($hn, $un, $pw, $db, $port);

  if ($conexion->connect_error) die ("Fatal error");

  //session_start();
  if (  isset($_SESSION['username']))
  { 
    //$username = htmlspecialchars($_SESSION['username']);
  $username = $_SESSION['username'];
  $query = "SELECT T.IDtarea ,T.titulo,T.descripcion,T.fecha ,T.FecVencimiento ,T.pasword, D.prioridad 
  FROM tarea T  inner join usuarios U on T.pasword=U.pasword  inner join detalle_tarea D on T.IDtarea=D.ID_tarea 
  where U.username='$username' ORDER BY T.FecVencimiento ASC";

  $result = $conexion->query($query);
  if (!$result) die ("Falló el acceso a la base de datos");
  $rows = $result->num_rows;
  echo <<<_END
  <center><h3> Todas las tareas </h3></center>
  <table border="1" bordercolor="black"><tr> 
  _END;

  for ($j = 0; $j < $rows; $j++){
        if ($j%5==0){
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
       <td BGCOLOR="gold" ><pre>
       
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