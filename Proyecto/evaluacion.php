<?php
session_start();
$host="127.0.0.1";
$port=3306;
$socket="";
$user="juez";
$password="passwordJuez";
$dbname="robotica";
$con = mysqli_connect($host, $user, $password, $dbname, $port, $socket);

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
or die('Could not connect to the database server' . mysqli_connect_error());


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idEquipo'])) {
    $idEquipo = $_POST["idEquipo"];
    $correoJurado = $_SESSION['correo'];
    $resultadoJurado = mysqli_query($con,"SELECT buscarIdJuradoPorCorreo('$correoJurado') AS idJurado");
    $rowObtenerIdJurado = $resultadoJurado->fetch_assoc();
    $idJurado = $rowObtenerIdJurado['idJurado'];
    mysqli_query($con,"call InsertarEvaluacion($idEquipo,$idJurado);");
    $sqlnombreEquipo = mysqli_query($con,"Select nombreEquipo from equipos where idEquipo = $idEquipo;");
    $rownombreEquipo = $sqlnombreEquipo ->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        form {
            width: 100%;
        }

        h2 {
            width: 100%;
            text-align: center;
        }

        h3 {
            margin-top: 10px;
            margin-bottom: 5px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        @media (min-width: 600px) {
            form {
                width: 30%;
            }
        }
    </style>
</head>
<body>
<?php

echo "<h1>Evaluación del equipo:".$rownombreEquipo['nombreEquipo']."</h1>";
?>

<form action="evaluarEvaluacion.php" method="post">
    <h2>Diseño</h2>
    <h3>Bitácora</h3>
    <label>
        <input type="checkbox" name="diseno_bitacora_fecha" value="respuesta1">
        Registro de Fechas
    </label>

    <label>
        <input type="checkbox" name="diseno_bitacora_cambios" value="respuesta2">
        Justificación de cambios en Prototipo
    </label>

    <label>
        <input type="checkbox" name="diseno_bitacora_diagramas" value="respuesta3">
        Diagramas e Imágenes
    </label>

    <label>
        <input type="checkbox" name="diseno_bitacora_ortografia" value="respuesta4">
        Ortografía y Redacción
    </label>

    <label>
        <input type="checkbox" name="diseno_bitacora_presentacion" value="respuesta5">
        Presentación
    </label>

    <h3>Medio Digital</h3>
    <label>
        <input type="checkbox" name="diseno_medio_digital_video" value="respuesta6">
        Video y Animación
    </label>

    <label>
        <input type="checkbox" name="diseno_medio_digital_autodesk" value="respuesta7">
        Diseño y Modelado en Autodesk Inventor
    </label>

    <label>
        <input type="checkbox" name="diseno_medio_digital_analisis" value="respuesta8">
        Análisis de Elementos
    </label>

    <label>
        <input type="checkbox" name="diseno_medio_digital_ensamble" value="respuesta9">
        Ensamble del Prototipo
    </label>

    <label>
        <input type="checkbox" name="diseno_medio_digital_acorde_robot" value="respuesta10">
        El modelo es acorde con el robot
    </label>

    <label>
        <input type="checkbox" name="diseno_medio_digital_acorde_simulacion" value="respuesta11">
        Está acorde la simulación con los cálculos obtenidos
    </label>

    <label>
        <input type="checkbox" name="diseno_medio_digital_restricciones" value="respuesta12">
        Restricciones de Movimientos (Rotación y Traslación de Partes)
    </label>


    <h2>Programación</h2>
    <h3>Inspección General</h3>
    <label>
        <input type="checkbox" name="programacion_inspeccion_general_robotc" value="respuesta1">
        Software de programación RobotC
    </label>

    <label>
        <input type="checkbox" name="programacion_inspeccion_general_uso_funciones" value="respuesta2">
        Uso de funciones
    </label>

    <label>
        <input type="checkbox" name="programacion_inspeccion_general_complejidad" value="respuesta3">
        Complejidad del programa
    </label>

    <label>
        <input type="checkbox" name="programacion_inspeccion_general_justificacion_secuencias" value="respuesta4">
        Justificación de las secuencias de programación
    </label>

    <label>
        <input type="checkbox" name="programacion_inspeccion_general_estructuras_funciones" value="respuesta5">
        Conocimiento de las estructuras y funciones aplicadas
    </label>

    <label>
        <input type="checkbox" name="programacion_inspeccion_general_rutinas_depuracion" value="respuesta6">
        Rutinas de Depuración de Código
    </label>

    <label>
        <input type="checkbox" name="programacion_inspeccion_general_codigo_modular" value="respuesta7">
        Creación de código modular (Compacto) y Eficiente
    </label>

    <h3>Sistema Autónomo</h3>
    <label>
        <input type="checkbox" name="programacion_sistema_autonomo_documentacion" value="respuesta8">
        Documentación de código en la plantilla del modo Autónomo
    </label>

    <label>
        <input type="checkbox" name="programacion_sistema_autonomo_vinculacion" value="respuesta9">
        Vinculación de las acciones del robot con el código en el modo autónomo
    </label>

    <label>
        <input type="checkbox" name="programacion_sistema_autonomo_declaracion_uso_depuracion_sensores" value="respuesta10">
        Declaración, uso y Depuración de Sensores
    </label>

    <h3>Sistema Manipulado</h3>
    <label>
        <input type="checkbox" name="programacion_sistema_manipulado_vinculo_joystick_robot" value="respuesta11">
        Vínculo entre el joystick y el Robot
    </label>

    <label>
        <input type="checkbox" name="programacion_sistema_manipulado_eficiencia_calibracion" value="respuesta12">
        Eficiencia en la calibración de modo Driver
    </label>

    <label>
        <input type="checkbox" name="programacion_sistema_manipulado_habilidad_manipulacion_joystick" value="respuesta13">
        Habilidad de manipulación del joystick
    </label>

    <label>
        <input type="checkbox" name="programacion_sistema_manipulado_respuesta_dispositivo_mando" value="respuesta14">
        Respuesta del dispositivo en función al mando
    </label>

    <label>
        <input type="checkbox" name="programacion_sistema_manipulado_documentacion" value="respuesta15">
        Documentación de código en la plantilla modo driver
    </label>

    <h3>Demostración</h3>
    <label>
        <input type="checkbox" name="programacion_demostracion_demo_15_segundos" value="respuesta16">
        Realiza una demostración de 15 Segundos
    </label>

    <label>
        <input type="checkbox" name="programacion_demostracion_sin_inconvenientes" value="respuesta17">
        No presenta inconvenientes durante la ejecución de la rutina
    </label>

    <label>
        <input type="checkbox" name="programacion_demostracion_cumple_objetivo_modo_driver" value="respuesta18">
        Demuestra que el equipo cumple con el objetivo en modo driver
    </label>

    <label>
        <input type="checkbox" name="programacion_demostracion_explicacion_rutina_autonoma" value="respuesta19">
        Explicación de la rutina del modo autónomo
    </label>

    <h2>Construcción</h2>
    <h3>Inspección General</h3>
    <label>
        <input type="checkbox" name="construccion_inspeccion_general_prototipo_estetico" value="respuesta1">
        Prototipo Estético
    </label>

    <label>
        <input type="checkbox" name="construccion_inspeccion_general_estructuras_estables" value="respuesta2">
        Estructuras Estables
    </label>

    <label>
        <input type="checkbox" name="construccion_inspeccion_general_uso_sistemas_transmision" value="respuesta3">
        Uso de Sistemas de Transmisión
    </label>

    <label>
        <input type="checkbox" name="construccion_inspeccion_general_uso_sensores" value="respuesta4">
        Uso de Sensores
    </label>

    <label>
        <input type="checkbox" name="construccion_inspeccion_general_cableado_adecuado" value="respuesta5">
        El cableado adecuado
    </label>

    <label>
        <input type="checkbox" name="construccion_inspeccion_general_calculo_implementacion_sistema_neumatico" value="respuesta6">
        Cálculo e implementación del sistema neumático
    </label>

    <label>
        <input type="checkbox" name="construccion_inspeccion_general_conocimiento_alcance_robot" value="respuesta7">
        Conocimiento del alcance del robot
    </label>

    <label>
        <input type="checkbox" name="construccion_inspeccion_general_implementacion_estructura_dispositivos_vex_robotics" value="respuesta8">
        Implementación únicamente de Estructura y Dispositivos de la marca VEX ROBOTICS
    </label>

    <label>
        <input type="checkbox" name="construccion_inspeccion_general_uso_un_solo_procesador_stmicroelectronics" value="respuesta9">
        Uso de un solo Procesador STMicroelectronics ARM Cortex-M3
    </label>

    <h3>Libreta de Ingeniería</h3>

    <label>
        <input type="checkbox" name="construccion_libreta_analisis_estructuras" value="respuesta11">
        Análisis de Estructuras
    </label>

    <label>
        <input type="checkbox" name="construccion_libreta_relacion_velocidades_angulares" value="respuesta12">
        Relación de Velocidades Angulares
    </label>

    <label>
        <input type="checkbox" name="construccion_libreta_tren_engranes" value="respuesta13">
        Tren de Engranajes
    </label>

    <label>
        <input type="checkbox" name="construccion_libreta_centro_gravedad" value="respuesta14">
        Centro de Gravedad
    </label>

    <label>
        <input type="checkbox" name="construccion_libreta_sistemas_transmision" value="respuesta15">
        Sistemas de Transmisión
    </label>

    <label>
        <input type="checkbox" name="construccion_libreta_potencia" value="respuesta16">
        Potencia
    </label>

    <label>
        <input type="checkbox" name="construccion_libreta_torque" value="respuesta17">
        Torque
    </label>

    <label>
        <input type="checkbox" name="construccion_libreta_velocidad" value="respuesta18">
        Velocidad
    </label>
<?php
echo "<input type='hidden' name='idEquipo' value='$idEquipo'>";
?>

    <input type="submit" name = "EnviarEvaluacion" value="EnviarEvaluacion">
</form>



</body>
</html>
