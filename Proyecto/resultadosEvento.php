<?php
session_start()?>
<!DOCTYPE html>

<html lang="es">
<head>

<?php
 $host="127.0.0.1";
            $port=3306;
            $socket="";
            $user="admin";
            $password="passwordAdmin";
            $dbname="robotica";

            $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
            or die ('Could not connect to the database server' . mysqli_connect_error());

if (isset($_GET['evento'])) {
    $eventoSeleccionado = $_GET['evento'];
$sqlEquipos = "SELECT equipos.nombreEquipo, equipos.categoria
                   FROM equipos 
                   INNER JOIN evaluaciones ON equipos.idEquipo = evaluaciones.idEquipo
                   WHERE equipos.idEvento = $eventoSeleccionado";

$resultEquipos = $con->query($sqlEquipos);
    $equiposPorNivel = array('Primaria' => 0, 'Secundaria' => 0, 'Bachillerato' => 0, 'Profesional' => 0);

    // Almacena los resultados en un array
    $equiposArray = array();
    while ($row = $resultEquipos->fetch_assoc()) {
        $equiposArray[] = $row;
        $nivel = $row['categoria'];
        $equiposPorNivel[$nivel]++;
    }
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados del Evento</title>
</head>
<body>

<?php
$datosEventoR = mysqli_query($con, "SELECT eventos.fecha, eventos.horario, sedes.nombreSede, ubicaciones.estado, ubicaciones.municipio, ubicaciones.colonia, ubicaciones.calle, ubicaciones.numero
        FROM eventos 
        INNER JOIN sedes ON eventos.idSede = sedes.idSede
        INNER JOIN ubicaciones ON sedes.idUbicacion = ubicaciones.idUbicacion
        WHERE $eventoSeleccionado = eventos.idEvento;");
$row = $datosEventoR->fetch_assoc();


echo "<h2>Equipos registrados para el evento " . $row["fecha"] . "</h2>";
if (count($equiposArray) > 0) {
    echo "<ul>";
    foreach ($equiposArray as $rowEquipo) {

        $nombreEquipo = $rowEquipo['nombreEquipo'];
        $categoriaEquipo = $rowEquipo['categoria'];

        $Diseno = mysqli_query($con,"select CalcularCalificacionDiseno('$nombreEquipo') as Diseno;");
        $rowDisenoCal = $Diseno->fetch_assoc();
        $Programacion = mysqli_query($con,"select CalcularCalificacionProgramacion('$nombreEquipo') as Programacion;");
        $rowProgramacionCal = $Programacion->fetch_assoc();
        $Construccion = mysqli_query($con,"select CalcularCalificacionConstruccion('$nombreEquipo') as Construccion;");
        $rowConstruccionCal = $Construccion ->fetch_assoc();

        $DisenoCal = $rowDisenoCal['Diseno'];
        $ProgramacionCal = $rowProgramacionCal['Programacion'];
        $ConstruccionCal = $rowConstruccionCal['Construccion'];


        echo "<li>$nombreEquipo - Categoría: $categoriaEquipo</li>";
        if($DisenoCal == 10.00 && $ProgramacionCal==10.00 && $ConstruccionCal == 10.00)
            echo "<li> Calificaciones PERFECTAS: Diseno: $DisenoCal Programacion: $ProgramacionCal Construccion: $ConstruccionCal </li>";
        else
        echo "<li> Calificaciones: Diseno: $DisenoCal Programacion: $ProgramacionCal Construccion: $ConstruccionCal </li>";
    }
    echo "</ul>";
    echo "<h2>Cantidad de equipos por nivel:</h2>";
    echo "<ul>";
    foreach ($equiposPorNivel as $nivel => $cantidad) {
        echo "<li>$nivel: $cantidad equipos</li>";
    }
    echo "</ul>";
    echo "<a href='paginasAdmin.php'> Regresar </a>";
} else {
    echo '<script>alert("No hay equipos para este evento."); window.location.href = "paginasAdmin.php";</script>';;
}
} else {
    echo '<script>alert("Integrante añadido con éxito."); window.location.href = "paginasAdmin.php";</script>';;
}
?>

</body>
</html>
