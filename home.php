<style> body
   {
   background-image:url('notita3.jpg'); 
   background-size: 100% 100%;
   }
   </style> 
   
<?php //en la parte superior se agrego una imagen como fondo que ocupa 
      // el 100% de la pagina
    require_once 'login.php';
    require_once 'cerrar.php';
    
    $conexion = new mysqli($hn, $un, $pw, $db, $port);

    if ($conexion->connect_error) die ("Fatal error");

    //session_start();  se abre en el scipt cerrar.php y este usa el archivo mencionado
    if ( isset($_SESSION['username']))
    {   
        $nombre = $_SESSION['nombre'];
        $username = $_SESSION['username'];
       // echo ("".$_SESSION['username']."");
        echo <<<_END
           <br><H1 align="center">AGREGA TUS NOTAS DE TAREA </H1>
        _END;  
        echo " <br> Bienvenido  <b>$nombre</b>";
     // eliminando tarea       
        if (isset($_POST['delete']) && isset($_POST['idtarea'])){   
              $idtarea = get_post($conexion, 'idtarea');
              $query = "DELETE FROM tarea WHERE idtarea='$idtarea'";
              $result = $conexion->query($query);
             if (!$result ) echo "BORRAR falló"; 
           }
    // llenado del formulario ADD Task
        if (isset($_POST['titulo']) &&
           isset($_POST['detalle']) &&
           isset($_POST['vencimiento']) &&
           isset($_POST['hora']))
          { 
              echo "$username";
              $query="SELECT pasword FROM usuarios WHERE username='$username'";
              $result = $conexion->query($query);
              if (!$result) die ("Falló el acceso a la base de datos1"); 
            
              $rows1 = $result->num_rows;
              for ($j = 0; $j < $rows1; $j++)
              {
                 $row = $result->fetch_array(MYSQLI_NUM);
                 $r0 = htmlspecialchars($row[0]); 
                  // fecha de la zona 
                  //---------------------------------------
                  date_default_timezone_set('America/lima');
                  $fecha= date("Y-n-d G:i:00");
                  //---------------------------------------
                  $titulo = get_post($conexion, 'titulo');
                  $detalle = get_post($conexion, 'detalle');
                  $vencimientos = get_post($conexion, 'vencimiento');
                  $hora = get_post($conexion, 'hora');
                  $vencimiento = "$vencimientos"." "."$hora";
                  $hora = get_post($conexion, 'hora');
                  $pasword =$r0;
                  $prioridad =get_post($conexion, 'prioridad');
        
                  $query = "INSERT INTO tarea VALUE(NULL,'$titulo','$detalle','$fecha', '$vencimiento','$pasword')";  
                  $result = $conexion->query($query);
                  $insertID = $conexion->insert_id; 
                  $query = "INSERT INTO detalle_tarea  VALUE('$insertID' ,'$prioridad')";
                  $result= $conexion->query($query); 

                if (!$result) echo "INSERT FALLO";
              }

           }
   
          echo <<<_END
                <P align= right> <a href='logout.php'>SALIR</a> </p>
                <center><i><h4>AGREGAR TAREAS</h4></i></center>
              <center><form action="home.php" method="post"><pre>
               Titulo    <input type="text" name="titulo" required>
               detalle   <textarea name="detalle" rows="4"cols="21">Escribe los detalles aqui</textarea><br>
             F-V        <input type="date" name="vencimiento" required><br>
           hora          <input type="time" name="hora" required><br>
           Prioridad     <select name="prioridad" >
                           
                            <option value="alta">Alta</option>
                            <option value="baja">Baja</option>
                         </select> <br>
                         <input type="submit" value="ADD TASK">
              </pre></form></center>
           _END;

         echo <<<_END
                  <h3>Ver tareas </h3>
         <pre><a href='pendientes.php'>VER TAREAS PENDIENTES</a></pre>
         <pre><a href='tareaVen.php'>VER TAREAS VENCIDAS</a></pre>
         <pre><a href='tareaArc.php'>VER TAREAS ARCHIVADAS</a></pre>
         <pre><a href='Todas.php'>VER TODAS</a></pre>
         <center><h3><i>Tareas urgentes a realizar !!</i></h3></center>
        _END;  
//---------------Seleccion de usuario logeado----------------------
       $query="SELECT pasword FROM usuarios WHERE username='$username' ";
       $result = $conexion->query($query);
       if (!$result) die ("Falló el acceso a la base de datos1"); 
       echo <<<_END
       <table border="1" bordercolor="purple" BORDER CELLPADDING=10 CELLSPACING=0><tr> 
       _END; 

       $rows1 = $result->num_rows;
       for ($j = 0; $j < $rows1; $j++)
       {
           $row1 = $result->fetch_array(MYSQLI_NUM);
           $m0 = htmlspecialchars($row1[0]); 

           $query = "SELECT T.IDtarea ,T.titulo,T.descripcion,T.fecha ,T.FecVencimiento ,T.pasword, D.prioridad 
           FROM tarea T inner join detalle_tarea D on T.IDtarea=D.ID_tarea
           WHERE D.prioridad='alta' and T.pasword='$m0' ORDER BY T.FecVencimiento ASC ";
           $result = $conexion->query($query);
           if (!$result) die ("Falló el acceso a la base de datos general ");
          
           $rows = $result->num_rows;
           for ($j = 0; $j < $rows; $j++)
             {
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
               <td BGCOLOR="pink">
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
                {  // mientras la fV no se mayor a la fecha actual se fostrara el boton de archivar y actualizar
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
                   </form>
                   _END; 

                } else 
                   { // si es mayor se concidera vencida y se hace una actualizacion
                    echo (" Tarea vencida");
                     $query = " UPDATE detalle_tarea SET prioridad='Vencida' WHERE ID_tarea='$r0' "; 
                     $result1 = $conexion->query($query);
                    if (!$result1) echo "UPDATE FALLO ";
                   }  
              }
              echo <<<_END
              </td>
              _END;
         }
      $result->close();
      echo <<<_END
       </table>
      _END;
    }
    else {echo "Por favor <a href=signin.php>Click aqui</a>
                para ingresar"; header('Location: signin.php');}
//--------------------------------------------------------
//--------------funciones --------------------------------
       $conexion->close();
    function get_post($con, $var)
    {
        return $con->real_escape_string($_POST[$var]);
    } 

    function mysql_entities_fix_string($conexion, $string)
    {
        return htmlentities(mysql_fix_string($conexion, $string));
      }
    function mysql_fix_string($conexion, $string)
    {
       // if (get_magic_quotes_gpc()) $string = stripslashes($string);
        return $conexion->real_escape_string($string);
    } 
    
    
?>

