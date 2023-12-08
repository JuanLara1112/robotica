<?php
session_start();
$host = "127.0.0.1";
$port = 3306;
$socket = "";
$user = "preusuario";
$password = "passwordPreusuario";
$dbname = "robotica";
$con = mysqli_connect($host, $user, $password, $dbname, $port, $socket);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (isset($_POST["formulario"]) && $_POST["formulario"] === "registro") {
$contrasenaR = $_POST["contrasenaR"];
$repiteContrasenaR = $_POST["repiteContrasenaR"];
$correoR = $_POST["correoR"];
$_SESSION['correo'] = $correoR;
    if ($contrasenaR === $repiteContrasenaR) {
        $consultaCorreoUsado = mysqli_query($con, "SELECT checarCorreo('$correoR') AS resultado;");
        $correoUsado = mysqli_fetch_assoc($consultaCorreoUsado);
        echo 'hasta aqui';
        if(!$correoUsado['resultado']) {
            $rol = $_POST["rol"];
            $nombresR = $_POST["nombresR"];
            $apellidoPR = $_POST["apellidoPR"];
            $apellidoMR = $_POST["apellidoMR"];
            $institucion = $_POST["institucion"];
            $estadoI = $_POST["estado"];
            $municipioI = $_POST["municipio"];
            $coloniaI = $_POST["colonia"];
            $calleI = $_POST["calle"];
            $numeroI= intval($_POST["numero"]);
            $codigoPostalI = intval($_POST["codigo_postal"]);
            switch ($rol) {
                case 'Juez':
                    $nivelAcademico = $_POST["nivelAcademico"];
                    $host="127.0.0.1";
                    $port=3306;
                    $socket="";
                    $user="juez";
                    $password="passwordJuez";
                    $dbname="robotica";
                    $con = mysqli_connect($host, $user, $password, $dbname, $port, $socket)
                    or die ('Could not connect to the database server' . mysqli_connect_error());

                    mysqli_query($con, "CALL InsertarUbicacion('$estadoI','$municipioI','$coloniaI','$calleI',$numeroI,$codigoPostalI);");
                    mysqli_query($con, "CALL InsertarInstitucion('$institucion', '$estadoI', '$municipioI', '$coloniaI', '$calleI', $numeroI, $codigoPostalI)");
                    mysqli_query($con, "CALL InsertarJurado('$nombresR', '$apellidoPR', '$apellidoMR', '$correoR', '$nivelAcademico','$institucion');");

                    mysqli_query($con,"CALL InsertarUsuario('$correoR', '$contrasenaR', 'Juez')");

                    header("Location: paginasJuez.php");
                    exit();
                case 'Asesor':
                    $host="127.0.0.1";
                    $port=3306;
                    $socket="";
                    $user="asesor";
                    $password="passwordAsesor";
                    $dbname="robotica";
                    $con = mysqli_connect($host, $user, $password, $dbname, $port, $socket)
                    or die ('Could not connect to the database server' . mysqli_connect_error());
                    mysqli_query($con, "CALL InsertarUbicacion('$estadoI','$municipioI','$coloniaI','$calleI',$numeroI,$codigoPostalI);");
                    mysqli_query($con,"CALL InsertarInstitucion('$institucion','$estadoI','$municipioI','$coloniaI','$calleI',$numeroI,$codigoPostalI);");
                    mysqli_query($con,"CALL InsertarAsesor('$nombresR', '$apellidoPR', '$apellidoMR', '$correoR', '$institucion');");
                    mysqli_query($con,"CALL InsertarUsuario('$correoR', '$contrasenaR', 'Asesor')");

                    header("Location: paginasAsesor.php");
                    exit();
                case 'JuezAsesor':
                    $nivelAcademico = $_POST["nivelAcademico"];
                    $host="127.0.0.1";
                    $port=3306;
                    $socket="";
                    $user="juezasesor";
                    $password="passwordJuezAsesor";
                    $dbname="robotica";

                    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
                    or die ('Could not connect to the database server' . mysqli_connect_error());
                    mysqli_query($con, "CALL InsertarUbicacion('$estadoI','$municipioI','$coloniaI','$calleI',$numeroI,$codigoPostalI);");
                    mysqli_query($con,"CALL InsertarInstitucion('$institucion','$estadoI','$municipioI','$coloniaI','$calleI',$numeroI,$codigoPostalI);");
                    mysqli_query($con,"CALL InsertarJurado('$nombresR', '$apellidoPR', '$apellidoMR', '$correoR', '$nivelAcademico','$institucion');");
                    mysqli_query($con,"CALL InsertarAsesor('$nombresR', '$apellidoPR', '$apellidoMR', '$correoR', '$institucion');");
                    mysqli_query($con,"CALL InsertarUsuario('$correoR', '$contrasenaR', 'JuezAsesor')");

                    header("Location: paginasJuezAsesor.php");
                    exit();
                case 'Admin':
                    $host="127.0.0.1";
                    $port=3306;
                    $socket="";
                    $user="adminEvento";
                    $password="";
                    $dbname="robotica";

                    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
                    or die ('Could not connect to the database server' . mysqli_connect_error());
                    header("Location: paginasAdmin.php");
                    exit();


                default:
                    echo "<script>
            alert('Error Rol no existente. Redirigiendo al login');
            window.location.href = 'index.php';
          </script>";
                    exit();
            }






        }
        else{
            "<script>
            alert('Este correo ya está siendo usado.');
            window.location.href = 'registro.php';
          </script>";
        }
    } else {
        "<script>
            alert('Las contraseñas no coinciden.');
            window.location.href = 'registro.php';
          </script>";
    }
}

}
?>