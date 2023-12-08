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
$idEquipo = intval($_POST['idEquipo']);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['EnviarEvaluacion'])) {
    function checkboxToBool($value)
    {
        return isset($value) ? 1 : 0;
    }
    $resultadoIdEvaluacion = mysqli_query($con,"Select buscarIdEvaluacion($idEquipo) as idEvaluacion;");
    $rowIdEvaluacion = $resultadoIdEvaluacion -> fetch_assoc();
    $idEvaluacion = $rowIdEvaluacion['idEvaluacion'];
    $sqlInsertBitacora = "CALL InsertarBitacora($idEvaluacion, 
                                               " . checkboxToBool($_POST['diseno_bitacora_fecha']??null) . ",
                                               " . checkboxToBool($_POST['diseno_bitacora_cambios']??null) . ",
                                               " . checkboxToBool($_POST['diseno_bitacora_diagramas']??null) . ",
                                               " . checkboxToBool($_POST['diseno_bitacora_ortografia']??null) . ",
                                               " . checkboxToBool($_POST['diseno_bitacora_presentacion']??null) . ");";
    $con->query($sqlInsertBitacora);

    $sqlInsertMedioDigital = "CALL InsertarMedioDigital($idEvaluacion, 
                                                       " . checkboxToBool($_POST['diseno_medio_digital_video']??null) . ",
                                                       " . checkboxToBool($_POST['diseno_medio_digital_autodesk']??null) . ",
                                                       " . checkboxToBool($_POST['diseno_medio_digital_analisis']??null) . ",
                                                       " . checkboxToBool($_POST['diseno_medio_digital_ensamble']??null) . ",
                                                       " . checkboxToBool($_POST['diseno_medio_digital_acorde_robot']??null) . ",
                                                       " . checkboxToBool($_POST['diseno_medio_digital_acorde_simulacion']??null) . ",
                                                       " . checkboxToBool($_POST['diseno_medio_digital_restricciones']??null) . ");";
    $con->query($sqlInsertMedioDigital);

    $sqlInsertInspeccionGeneralProg = "CALL InsertarInspeccionGeneralProg($idEvaluacion, 
                                                                       " . checkboxToBool($_POST['programacion_inspeccion_general_robotc']??null) . ",
                                                                       " . checkboxToBool($_POST['programacion_inspeccion_general_uso_funciones']??null) . ",
                                                                       " . checkboxToBool($_POST['programacion_inspeccion_general_complejidad']??null) . ",
                                                                       " . checkboxToBool($_POST['programacion_inspeccion_general_justificacion_secuencias']??null) . ",
                                                                       " . checkboxToBool($_POST['programacion_inspeccion_general_estructuras_funciones']??null) . ",
                                                                       " . checkboxToBool($_POST['programacion_inspeccion_general_rutinas_depuracion']??null) . ",
                                                                       " . checkboxToBool($_POST['programacion_inspeccion_general_codigo_modular']??null) . ");";
    $con->query($sqlInsertInspeccionGeneralProg);

    $sqlInsertSistemaAutonomo = "CALL InsertarSistemaAutonomo($idEvaluacion, 
                                                             " . checkboxToBool($_POST['programacion_sistema_autonomo_documentacion']??null) . ",
                                                             " . checkboxToBool($_POST['programacion_sistema_autonomo_vinculacion']??null) . ",
                                                             " . checkboxToBool($_POST['programacion_sistema_autonomo_declaracion_uso_depuracion_sensores']??null) . ");";
    $con->query($sqlInsertSistemaAutonomo);


    $sqlInsertSistemaManipulado = "CALL InsertarSistemaManipulado($idEvaluacion, 
    " . checkboxToBool($_POST['programacion_sistema_manipulado_vinculo_joystick_robot'] ?? null) . ",
    " . checkboxToBool($_POST['programacion_sistema_manipulado_eficiencia_calibracion'] ?? null) . ",
    " . checkboxToBool($_POST['programacion_sistema_manipulado_habilidad_manipulacion_joystick'] ?? null) . ",
    " . checkboxToBool($_POST['programacion_sistema_manipulado_respuesta_dispositivo_mando'] ?? null) . ",
    " . checkboxToBool($_POST['programacion_sistema_manipulado_documentacion'] ?? null) . ");";

    $con->query($sqlInsertSistemaManipulado);


    $sqlInsertDemostracion = "CALL InsertarDemostracion($idEvaluacion, 
                                                       " . checkboxToBool($_POST['programacion_demostracion_demo_15_segundos']??null) . ",
                                                       " . checkboxToBool($_POST['programacion_demostracion_sin_inconvenientes']??null) . ",
                                                       " . checkboxToBool($_POST['programacion_demostracion_cumple_objetivo_modo_driver']??null) . ",
                                                       " . checkboxToBool($_POST['programacion_demostracion_explicacion_rutina_autonoma']??null) . ");";
    $con->query($sqlInsertDemostracion);

    $sqlInsertInspeccionGeneralCons = "CALL InsertarInspeccionGeneralCons($idEvaluacion, 
                                                                         " . checkboxToBool($_POST['construccion_inspeccion_general_prototipo_estetico']??null) . ",
                                                                         " . checkboxToBool($_POST['construccion_inspeccion_general_estructuras_estables']??null) . ",
                                                                         " . checkboxToBool($_POST['construccion_inspeccion_general_uso_sistemas_transmision']??null) . ",
                                                                         " . checkboxToBool($_POST['construccion_inspeccion_general_uso_sensores']??null) . ",
                                                                         " . checkboxToBool($_POST['construccion_inspeccion_general_cableado_adecuado']??null) . ",
                                                                         " . checkboxToBool($_POST['construccion_inspeccion_general_calculo_implementacion_sistema_neumatico']??null) . ",
                                                                         " . checkboxToBool($_POST['construccion_inspeccion_general_conocimiento_alcance_robot']??null) . ",
                                                                         " . checkboxToBool($_POST['construccion_inspeccion_general_implementacion_estructura_dispositivos_vex_robotics']??null) . ",
                                                                         " . checkboxToBool($_POST['construccion_inspeccion_general_uso_un_solo_procesador_stmicroelectronics']??null) . ");";
    $con->query($sqlInsertInspeccionGeneralCons);

    $sqlInsertLibretaIngenieria = "CALL InsertarLibretaIngenieria($idEvaluacion,
                                                                 " . checkboxToBool($_POST['construccion_libreta_analisis_estructuras']) . ",
                                                                 " . checkboxToBool($_POST['construccion_libreta_relacion_velocidades_angulares']) . ",
                                                                 " . checkboxToBool($_POST['construccion_libreta_tren_engranes']) . ",
                                                                 " . checkboxToBool($_POST['construccion_libreta_centro_gravedad']) . ",
                                                                 " . checkboxToBool($_POST['construccion_libreta_sistema_transmision']) . ",
                                                                 " . checkboxToBool($_POST['construccion_libreta_potencia']) . ",
                                                                 " . checkboxToBool($_POST['construccion_libreta_torque']) . ",
                                                                 " . checkboxToBool($_POST['construccion_libreta_velocidad']) . ");";
    $con->query($sqlInsertLibretaIngenieria);

    echo '<script>alert("Evaluación enviada con éxito."); window.location.href = "paginasJuez.php";</script>';
}

