<?php 
    require_once 'login.php';
    $conexion = new mysqli($hn, $un, $pw, $db, $port);

    if($conexion->connect_error) die("Error fatal");
    session_start();

    if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
         header('Location: index.php');
    }
     session_destroy();

    if (isset($_POST['username'])&& isset($_POST['password']))
    {
        $un_temp = mysql_entities_fix_string($conexion, $_POST['username']);
        $pw_temp = mysql_entities_fix_string($conexion, $_POST['password']);
        $query   = "SELECT * FROM usuarios WHERE username='$un_temp'";
        $result  = $conexion->query($query);
        
        if (!$result) die ("Usuario no encontrado");
        elseif ($result->num_rows)
        {
            $row = $result->fetch_array(MYSQLI_NUM);
            $result->close();

            if (password_verify($pw_temp, $row[0])) 
            {
             //  header("Location: sqltest.php");
                session_start();
                $_SESSION['nombre']=mysql_fix_string($conexion,$row[1]);
                
                $_SESSION['username']= mysql_fix_string($conexion,$row[2]);
                $_SESSION['ultimoAcceso']= time();
                echo (" ".$_SESSION['username']."2" );
               // echo htmlspecialchars("$row[1]:hola $row[1], has ingresado como '$row[2]'");
               header('Location: home.php');
                die ("<p><a href='index.php'></a></p>");
            }
            else {
                echo "  <br> <br><center><b><i> Usuario/password incorrecto</i></b> </center>";
                
            }
        }
        else {
          echo " <br> <br><center><b><i> Usuario/password incorrecto</i></b> </center>";
      }   
    }
 
    echo <<<_END
    <br><br><br>
    <center>
        <h1><i>Iniciar sesion</i></h1>
    <form action="index.php" method="post"><pre>
    <b>Usuario</b>  <input type="text" name="username" required>
    <br><b>Password</b> <input type="password" name="password" required>
                  <br>
             <input type="submit" value="INGRESAR">
    </form>
    <i><b>Registrar usuario: </b></i><a href='signup.php'>Registrarme</a>
    </center>
    _END;
    
    $conexion->close();

    function mysql_entities_fix_string($conexion, $string)
    {
        return htmlentities(mysql_fix_string($conexion, $string));
      }
    function mysql_fix_string($conexion, $string)
    {
       // if (get_magic_quotes_gpc()) $string = stripslashes($string);
        return $conexion->real_escape_string($string);
    }  
    function get_post($con, $var)
    {
        return $con->real_escape_string($_POST[$var]);
    } 

?>