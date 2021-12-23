<?php //signup.php
      require_once 'login.php';
      require_once 'signup.php';
      $conexion = new mysqli($hn, $un, $pw, $db, $port);
  
      if ($conexion->connect_error) die ("Fatal error");

    if(isset($_POST['username']) && isset($_POST['password'])&& isset($_POST['reg']) )
    {
        $nombre = mysql_entities_fix_string($conexion, $_POST['nombre']);
        //$apellido = mysql_entities_fix_string($conexion, $_POST['apellido']);
        $username = mysql_entities_fix_string($conexion, $_POST['username']);
        $pw_temp = mysql_entities_fix_string($conexion, $_POST['password']);

        $password = password_hash($pw_temp, PASSWORD_DEFAULT);

        $query = "INSERT INTO usuarios VALUES( '$password','$nombre','$username')";

        $result = $conexion->query($query);
  
       if (!$result) die ("Falló registro");
     
        echo "SE REGITRO CORRECTAMENTE";
        header("Location: index.php ");
    }  
    else
    {
        echo <<<_END
        <br><br><br>
        <H1 align="center">REGISTRATE</H1>
        <center>
        <form action="signup.php" method="post"><pre>
        <br>Nombre   <input type="text" name="nombre" placeholder="*" required>
        <br>Apellido <input type="text" name="apellido">
        <br>Usuario  <input type="text" name="username" placeholder="*" required>
        <br>Password <input type="password" name="password" placeholder="Almenos 8 caracteres"required>
                 <input type="hidden" name="reg" value="yes">
                 <input type="submit" value="REGISTRAR">
        </form></center> <br>
        <center><i><b>Iniciar session: </b></i><a href='index.php'>clik Aqui</a></center>
        _END;
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