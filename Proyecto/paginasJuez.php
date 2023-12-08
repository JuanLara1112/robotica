<?php
session_start()?>

<?php
$host="127.0.0.1";
$port=3306;
$socket="";
$user="juez";
$password="passwordJuez";
$dbname="robotica";
$con = mysqli_connect($host, $user, $password, $dbname, $port, $socket);

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
        .logout-link {
            position: fixed;
            top: 10px;
            right: 10px;
            text-decoration: none;
            padding: 10px;
            background-color: #f00; /* Puedes cambiar el color de fondo según tus preferencias */
            color: #fff;
            border-radius: 5px;
        }

    </style>
</head>

<body>

<div class="logo">
    <img src="evento_de_concurso_logo.png" alt="Evento de Concurso Logo">
</div>
<a class="logout-link" href="logout.php">Cerrar Sesión</a>
<div class="login-tab">
    <div class="tab">
        <button class="tablinks" onclick="openTab(event, 'events')">Eventos</button>
        <button class="tablinks" onclick="openTab(event, 'evaluaciones')">Evaluaciones</button>

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


            $resultEquipos = mysqli_query($con,"SELECT * FROM equipos WHERE idEvento = $idEvento;");

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

    <div id="events" class="tabcontent">
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
</div>


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
</body>
</html>