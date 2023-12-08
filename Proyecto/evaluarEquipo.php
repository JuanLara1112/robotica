<?php
session_start();
$host="127.0.0.1";
$port=3306;
$socket="";
$user="asesor";
$password="passwordAsesor";
$dbname="robotica";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
or die ('Could not connect to the database server' . mysqli_connect_error());

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idEvento = $_POST['evento'];
    $nombreEquipo = $_POST['nombreEquipo'];
    $categoriaEquipo = $_POST['categoriaEquipo'];
    $correoAsesor = $_SESSION["correo"];
    $correoAsesorDatos = mysqli_query($con, "select buscarIdAsesorPorCorreo('$correoAsesor') as correo;");}
    $rowCorreoAsesorDatos = $correoAsesorDatos->fetch_assoc();
    $correoAsesorSQL = $rowCorreoAsesorDatos['correo'];
    $sqlInsertEquipo = "call InsertarEquipo('$nombreEquipo', '$categoriaEquipo', '$correoAsesorSQL', $idEvento)";

    if ($con->query($sqlInsertEquipo) === TRUE) {
        echo '<script>alert("Equipo añadido con éxito."); window.location.href = "paginasAsesor.php";</script>';
    } else {
        echo '<script>alert("Error al insertar el equipo: ".$con->error); window.location.href = paginasAsesor.php";</script>';
    }


