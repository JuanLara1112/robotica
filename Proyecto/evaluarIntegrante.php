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
    $nombreInt = $_POST['nombre'];
    $apellidoPatInt = $_POST['apellido_paterno'];
    $apellidoMatInt = $_POST['apellido_materno'];
    $edad = $_POST['edad'];
    $idEquipo = $_POST['equipo'];

    $verificarIntegrantes = "SELECT COUNT(*) as numIntegrantes FROM integrantes WHERE idEquipo = $idEquipo";
    $resultado = $con->query($verificarIntegrantes);

    if ($resultado) {
        $fila = $resultado->fetch_assoc();
        $numIntegrantes = $fila['numIntegrantes'];

        if ($numIntegrantes >= 4) {
            echo '<script>alert("El equipo ya tiene 4 integrantes. No se puede añadir más."); window.location.href = "paginasAsesor.php";</script>';
            exit();
        } else {
            $queryCategoriaEquipo = "SELECT categoria FROM equipos WHERE idEquipo = $idEquipo";
            $resultCategoriaEquipo = $con->query($queryCategoriaEquipo);

            if ($resultCategoriaEquipo) {
                $rowCategoriaEquipo = $resultCategoriaEquipo->fetch_assoc();
                $categoriaEquipo = $rowCategoriaEquipo['categoria'];

                if (($categoriaEquipo == 'Primaria' && $edad >= 5 && $edad <= 12) ||
                    ($categoriaEquipo == 'Secundaria' && $edad >= 12 && $edad <= 16) ||
                    ($categoriaEquipo == 'Bachillerato' && $edad >=15 && $edad <=18)||
                    ($categoriaEquipo == 'Profesional' && $edad >= 18 && $edad <=45)
        ) {
                    $integranteDatos = "CALL InsertarIntegrante('$nombreInt', '$apellidoPatInt', '$apellidoMatInt', $edad, $idEquipo)";
        }
            else
                echo '<script>alert("La edad del integrante no estaba en los rangos."); window.location.href = "paginasAsesor.php";</script>';
        }
    if ($con->query($integranteDatos) === TRUE) {
        echo '<script>alert("Integrante añadido con éxito."); window.location.href = "paginasAsesor.php";</script>';
    } else {
        echo '<script>alert("Error al insertar el integrante: ".$con->error); window.location.href = paginasAsesor.php";</script>';
    }

}}}