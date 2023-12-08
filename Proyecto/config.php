<?php
session_start();
$correoU = $_POST["correoU"];
$contrasenaU = $_POST["contrasenaU"];
$_SESSION['correo'] = $correoU;
$host = "127.0.0.1";
$port = 3306;
$socket = "";
$user = "preusuario";
$password = "passwordPreusuario";
$dbname = "robotica";
$con = mysqli_connect($host, $user, $password, $dbname, $port, $socket);
$correoU = mysqli_real_escape_string($con, $correoU);
$consultaCorreoExiste = mysqli_query($con,"SELECT checarCorreo('$correoU') as existe;");
$correoExiste = mysqli_fetch_assoc($consultaCorreoExiste);
if ($correoExiste['existe']) {

    $consutaRol = mysqli_query($con,"SELECT checarPrivilegios('$correoU') as resultado;");
    $rol = mysqli_fetch_assoc($consutaRol);
    #echo $rol;
    switch ($rol['resultado']) {
        case 'Juez':
            $host="127.0.0.1";
            $port=3306;
            $socket="";
            $user="juez";
            $password="passwordJuez";
            $dbname="robotica";
            break;
        case 'Asesor':
            $host="127.0.0.1";
            $port=3306;
            $socket="";
            $user="asesor";
            $password="passwordAsesor";
            $dbname="robotica";
            break;
        case 'JuezAsesor':
            $host="127.0.0.1";
            $port=3306;
            $socket="";
            $user="juezasesor";
            $password="passwordJuezAsesor";
            $dbname="robotica";
            $con = new mysqli($host, $user, $password, $dbname, $port, $socket);
            break;

        case 'Admin':
            $host="127.0.0.1";
            $port=3306;
            $socket="";
            $user="admin";
            $password="passwordAdmin";
            $dbname="robotica";

            $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
            or die ('Could not connect to the database server' . mysqli_connect_error());

            break;

        default:
            echo "<script>
            alert('Error Rol no existente. Redirigiendo al login');
            window.location.href = 'index.php';
          </script>";
            exit();
    }
    mysqli_close($con);


    $con = mysqli_connect($host, $user, $password, $dbname, $port, $socket)
    or die ('Could not connect to the database server' . mysqli_connect_error());
    $consultaContrasenaCorrecta = mysqli_query($con, "SELECT checarContrasena('$correoU','$contrasenaU') as correcta;");
    $contrasenaEsCorrecta = mysqli_fetch_assoc($consultaContrasenaCorrecta);
    if($contrasenaEsCorrecta['correcta'])
    {
        mysqli_close($con);
        switch ($rol['resultado']) {
            case 'Juez':
                header("Location: paginasJuez.php");
                exit();

            case 'Asesor':
                header("Location: paginasAsesor.php");
                exit();

            case 'JuezAsesor':
                header("Location: paginasJuezAsesor");
                exit();
            case 'Admin':
                header("Location: paginasAdmin.php");
                exit();
    }}
    else{
        echo "<script>
            alert('La contraseña es incorrecta.');
            window.location.href = 'index.php';
          </script>";
    }
}
else {
    echo "<script>
            alert('El usuario no existe. Coloque correctamente su usuario');
            window.location.href = 'index.php';
          </script>";
}

?>
