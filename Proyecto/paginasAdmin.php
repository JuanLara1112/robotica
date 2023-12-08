<?php

$host = "127.0.0.1";
$port = 3306;
$socket = "";
$user = "admin";
$password = "passwordAdmin";
$dbname = "robotica";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
or die ('Could not connect to the database server' . mysqli_connect_error());

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
            max-width: 800px;
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

<div class="logo">
    <img src="evento_de_concurso_logo.png" alt="Evento de Concurso Logo">
</div>
<a class="logout-link" href="logout.php">Cerrar Sesión</a>
<div class="login-tab">
    <div class="tab">
        <button class="tablinks" onclick="openTab(event, 'nuevoEvento')">Añadir Eventos</button>
        <button class="tablinks" onclick="openTab(event, 'historial')">Historial</button>
        <button class="tablinks" onclick="openTab(event, 'events')">Eventos</button>
    </div>

    <div id="historial" class="tabcontent">
        <?php
        $sqlEventos = "SELECT idEvento, fecha FROM eventos";
        $resultEventos = $con->query($sqlEventos);
        if (isset($_GET['evento'])) {
            $eventoSeleccionado = $_GET['evento'];
            $sqlEquipos = "SELECT nombreEquipo, categoria
                   FROM equipos 
                   WHERE equipos.idEvento = $eventoSeleccionado";

            $resultEquipos = $con->query($sqlEquipos);
            $equiposPorNivel = array('Primaria' => 0, 'Secundaria' => 0, 'Bachillerato' => 0, 'Profesional' => 0);

            while ($row = $resultEquipos->fetch_assoc()) {
                $nivel = $row['categoria'];
                $equiposPorNivel[$nivel]++;
            }
        }
        ?>
        <h1>Equipos por Evento</h1>
        <form method="GET" action="resultadosEvento.php">
            <label for="evento">Selecciona un evento:</label>
            <select id="evento" name="evento">
                <option value="" selected disabled>Selecciona un evento</option>
                <?php
                while ($rowEvento = $resultEventos->fetch_assoc()) {
                    $idEvento = $rowEvento['idEvento'];
                    $fechaEvento = $rowEvento['fecha'];
                    echo "<option value='$idEvento'>$fechaEvento</option>";
                }
                ?>
            </select>
            <button type="submit"> Buscar </button>
        </form>

        <?php
        if (isset($eventoSeleccionado)) {
            echo "<h2>Equipos registrados para el evento seleccionado:</h2>";
            if ($resultEquipos->num_rows > 0) {
                echo "<ul>";
                while ($rowEquipo = $resultEquipos->fetch_assoc()) {
                    $nombreEquipo = $rowEquipo['nombreEquipo'];
                    $categoriaEquipo = $rowEquipo['categoria'];
                    echo "<li>$nombreEquipo - Categoría: $categoriaEquipo</li>";
                }
                echo "</ul>";
                echo "<h2>Cantidad de equipos por nivel:</h2>";
                echo "<ul>";
                foreach ($equiposPorNivel as $nivel => $cantidad) {
                    echo "<li>$nivel: $cantidad equipos</li>";
                }
                echo "</ul>";
            } else {
                echo '<script>alert("No se seleccionó ningun evento."); window.location.href = "paginasAdmin.php";</script>';
            }
        }
        ?>
            </div>


    <div id="nuevoEvento" class="tabcontent">
        <h1>Agregar Evento</h1>

        <form method="POST">
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required>

            <label for="horario">Horario:</label>
            <input type="time" id="horario" name="horario" required>

            <label for="sede">Sede:</label>
            <select id="sede" name="sede" required>
                <?php
                $sql = "SELECT idSede, nombreSede FROM sedes";
                $result = $con->query($sql);
                if ($result->num_rows > 0) {
                    $sedes = array();
                    while ($row = $result->fetch_assoc()) {
                        $sedes[$row["idSede"]] = $row["nombreSede"];
                    }
                } else {

                    $sedes = array();
                }

                foreach ($sedes as $idSede => $nombreSede) {
                    echo "<option value='$idSede'>$nombreSede</option>";
                }
                ?>
                <option value="agregar_sede">Agregar Sede</option>
            </select>

            <div id="camposSede" >
                <label for="nombre_sede">Nombre de la Sede:</label>
                <input type="text" id="nombre_sede" name="nombre_sede" >

                <label for="estado">Estado:</label>
                <input type="text" id="estado" name="estado">

                <label for="municipio">Municipio:</label>
                <input type="text" id="municipio" name="municipio">

                <label for="colonia">Colonia:</label>
                <input type="text" id="colonia" name="colonia">

                <label for="calle">Calle:</label>
                <input type="text" id="calle" name="calle">

                <label for="numero">Número:</label>
                <input type="text" id="numero" name="numero">

                <label for="codigo_postal">Código Postal:</label>
                <input type="text" id="codigo_postal" name="codigo_postal">
            </div>

            <button type="submit">Agregar Evento</button>

        </form>
        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

               if (isset($_POST["fecha"]) && isset($_POST["horario"])) {
                   $fecha = $_POST['fecha'];
                   $fechaMySQL = date('Y-m-d', strtotime($fecha));

        $horario = $_POST["horario"];
        $estado = $_POST["estado"];
                $municipio = $_POST["colonia"];
                $colonia = $_POST["calle"];
                $calle = $_POST["calle"];
                $numero = $_POST["numero"];
                $codigoPostal = $_POST["codigo_postal"];

        $nombreSede = $_POST["nombre_sede"] ?? "";


        if (isset($_POST["sede"])) {
            $sedeSeleccionada = $_POST["sede"];
            if ($sedeSeleccionada == "agregar_sede") {
                $queryUbicacion = "CALL InsertarUbicacion('$estado', '$municipio', '$colonia', '$calle', $numero, $codigoPostal);";
                mysqli_query($con, $queryUbicacion);

                $querySede = "CALL InsertarSede('$nombreSede', '$estado', '$municipio', '$colonia', '$calle', $numero, $codigoPostal);";
                mysqli_query($con, $querySede);

                $queryEvento = "CALL InsertarEvento('$fechaMySQL', '$horario', '$nombreSede');";
                mysqli_query($con, $queryEvento);


            } else {
                $queryEvento = "CALL InsertarEvento('$fechaMySQL', '$horario', '$sedeSeleccionada');";
                mysqli_query($con, $queryEvento);

            }
        }

    } else {
        echo "Error: No se recibieron los datos esperados del formulario.";
    }

            echo "<script>
            alert('Evento agregado exitosamente.' );
        </script>";
            }



        ?>

        <script>
            const sedeSelect = document.getElementById('sede');
            const camposSede = document.getElementById('camposSede');
            sedeSelect.addEventListener('change', function () {
                if (sedeSelect.value === 'agregar_sede') {
                    camposSede.style.display = 'block';
                } else {
                    camposSede.style.display = 'none';
                }
            });
        </script>
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
        INNER JOIN sedes ON eventos.idSede = sedes.idSede
        INNER JOIN ubicaciones ON sedes.idUbicacion = ubicaciones.idUbicacion";

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


        </form>
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

</script>
</body>
</html>
