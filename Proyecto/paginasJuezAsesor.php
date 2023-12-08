<?php
session_start();
$host="127.0.0.1";
$port=3306;
$socket="";
$user="juezasesor";
$password="passwordJuezAsesor";
$dbname="robotica";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
or die ('Could not connect to the database server' . mysqli_connect_error());


$sqlEventos = "SELECT idEvento, fecha FROM eventos";
$resultEventos = $con->query($sqlEventos);
?>
<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            background-color: #D5F5E3;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .logout-link {
            position: fixed;
            top: 10px;
            right: 10px;
            text-decoration: none;
            padding: 10px;
            background-color: #f00;
            color: #fff;
            border-radius: 5px;
        }

        .login-tab {
            max-width: 450px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .tab {
            display: flex;
            justify-content: space-around;
            background-color: #4CAF50;
            border-radius: 5px;
        }

        .tab button {
            background-color: #4CAF50;
            color: #ffffff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .tab button:hover {
            background-color: #45a049;
        }

        .tabcontent {
            display: none;
        }

        .active {
            display: block;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        select {
            width: 90%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"],
        button {
            background-color: #4CAF50;
            color: #ffffff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }

        input[type="submit"]:hover,
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
<script>
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
<div class="logo">
    <img src="evento_de_concurso_logo.png" alt="Evento de Concurso Logo">
</div>
<a class="logout-link" href="logout.php">Cerrar Sesión</a>
<div class="login-tab">
    <div class="tab">
        <button class="tablinks" onclick="openTab(event, 'equipo')">Añadir Equipo</button>
        <button class="tablinks" onclick="openTab(event, 'eventos')">Eventos</button>
        <button class="tablink" onclick="openTab(event,'integrante')"> Añadir integrante</button>
        <button class="tablink" onclick="openTab(event,'evaluaciones')"> Evaluaciones </button>

    </div>
    <div id="equipo" class="tabcontent">
        <h2>Añadir Equipo</h2>
        <form action="evaluarEquipo.php" method="post">
            <label for="evento">Seleccione un evento:</label>
            <select id="evento" name="evento" required>
                <?php
                while ($rowEvento = $resultEventos->fetch_assoc()) {
                    echo "<option value='{$rowEvento['idEvento']}'>{$rowEvento['fecha']}</option>";
                }
                ?>
            </select>

            <label for="nombreEquipo">Nombre del Equipo:</label>
            <input type="text" id="nombreEquipo" name="nombreEquipo" required>

            <label for="categoriaEquipo">Categoría del Equipo:</label>
            <select id="categoriaEquipo" name="categoriaEquipo" required>
                <?php
                $sqlNivelAcademico = mysqli_query($con,"Select buscarNivelAcademicoJurado('".$_SESSION['correo']."') as nivel;");
                $rowNivelAcademico = $sqlNivelAcademico->fetch_assoc();
                $nivelAcademico = $rowNivelAcademico['nivel'];
                 switch ($nivelAcademico){
                     case'Primaria':
                         echo "<option value='Secundaria'>Secundaria</option>";
                         echo"<option value='Bachillerato'>Bachillerato</option>";
                         echo "<option value='Profesional'>Profesional</option>";
                         break;
                     case'Secundaria':
                         echo "<option value='Primaria'>Primaria</option>";
                         echo"<option value='Bachillerato'>Bachillerato</option>";
                         echo "<option value='Profesional'>Profesional</option>";
                         break;
                     case 'Bachillerato':
                         echo "<option value='Primaria'>Primaria</option>";
                         echo"<option value='Secundaria'>Secundaria</option>";
                         echo "<option value='Profesional'>Profesional</option>";
                         break;
                     case 'Profesional':
                         echo "<option value='Primaria'>Primaria</option>";
                         echo"<option value='Secundaria'>Secundaria</option>";
                         echo "<option value='Bachillerato'>Bachillerato</option>";
                         break;
                 }

                ?>
                <option value="Primaria">Primaria</option>
                <option value="Secundaria">Secundaria</option>
                <option value="Bachillerato">Bachillerato</option>
                <option value="Profesional">Profesional</option>
            </select>
            <input type="submit" value="Añadir Equipo">
        </form>

    </div>
    <div id="eventos" class="tabcontent">
        <h2>Eventos</h2>
        <?php
        if(isset($con)){

            if ($con->connect_error) {
                die("Error de conexión a la base de datos: " . $con->connect_error);
            }
            $sql = "SELECT eventos.fecha, eventos.horario, sedes.nombreSede, ubicaciones.estado, ubicaciones.municipio, ubicaciones.colonia, ubicaciones.calle, ubicaciones.numero
        FROM eventos
        JOIN sedes ON eventos.idSede = sedes.idSede
        JOIN ubicaciones ON sedes.idUbicacion = ubicaciones.idUbicacion";

            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                echo "<table border='1'>
            <tr>
                <th>Fecha</th>
                <th>Horario</th>
                <th>Sede</th>
                <th>Estado</th>
                <th>Municipio</th>
                <th>Colonia</th>
                <th>Calle</th>
                <th>Número</th>
            </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                <td>{$row['fecha']}</td>
                <td>{$row['horario']}</td>
                <td>{$row['nombreSede']}</td>
                <td>{$row['estado']}</td>
                <td>{$row['municipio']}</td>
                <td>{$row['colonia']}</td>
                <td>{$row['calle']}</td>
                <td>{$row['numero']}</td>
              </tr>";
                }
                echo "</table>";
            } else {
                echo "No hay eventos disponibles.";
            }

        }

        ?>





    </div>
    <div id="integrante" class="tabcontent">

        <h1>Alta de Alumnos</h1>

        <form action="evaluarIntegrante.php" method="POST">
            <label for="equipo">Equipo:</label>
            <select id="equipo" name="equipo" required>
                <?php
                $queryEquipos = "SELECT idEquipo, nombreEquipo FROM equipos";
                $resultEquipos = $con->query($queryEquipos);

                if ($resultEquipos) {
                    while ($rowEquipo = $resultEquipos->fetch_assoc()) {
                        echo "<option value='{$rowEquipo['idEquipo']}'>{$rowEquipo['nombreEquipo']}</option>";
                    }
                } else {
                    echo "Error al obtener los equipos: " . $con->error;
                }
                ?>
            </select>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="apellido_paterno">Apellido Paterno:</label>
            <input type="text" id="apellido_paterno" name="apellido_paterno" required>

            <label for="apellido_materno">Apellido Materno:</label>
            <input type="text" id="apellido_materno" name="apellido_materno" required>

            <label for="edad">Edad:</label>
            <input type="number" id="edad" name="edad" required>

            <button type="submit">Enviar</button>
        </form>
    </div>

    <div id="evaluaciones" class="tabcontent">
        <h2>Evaluaciones</h2>
        <?php
        $sqlEventos = "SELECT * FROM eventos";
        $resultEventos = $con->query($sqlEventos);

        while ($rowEvento = $resultEventos->fetch_assoc()) {
            $idEvento = $rowEvento['idEvento'];
            $fecha = $rowEvento['fecha'];

            echo "<h2>Fecha del evento: $fecha</h2>";


            $resultEquipos = mysqli_query($con,"SELECT * FROM equipos WHERE idEvento = $idEvento AND categoria not like '$nivelAcademico' ;");

            while ($rowEquipo = $resultEquipos->fetch_assoc()) {
                $idEquipo = $rowEquipo['idEquipo'];
                $nombreEquipo = $rowEquipo['nombreEquipo'];
                $categoriaEquipo = $rowEquipo['categoria'];

                $sqlEvaluacion = "SELECT * FROM evaluaciones WHERE idEquipo = $idEquipo";
                $resultEvaluacion = $con->query($sqlEvaluacion);
                $evaluacionExistente = ($resultEvaluacion->num_rows > 0);

                echo "<p>Equipo: $nombreEquipo - Categoría: $categoriaEquipo</p>";

                if ($evaluacionExistente) {
                    echo "<p>Ya existe una evaluación asociada a este equipo.</p>";
                } else {
                    echo '<form action="evaluacion.php" method="post">';
                    echo "<input type='hidden' name='idEquipo' value='$idEquipo'>";
                    echo '<input type="submit" value="Comenzar Evaluación">';
                    echo '</form>';
                }
            }
        }

        ?>

    </div>


</div>

</body></html>



