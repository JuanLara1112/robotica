<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["formulario"])) {
        $tipoForm = $_POST["formulario"];

        if ($tipoForm == "login") {
          include ('config.php');
            if(isset($rol['resultado']))
                switch ($rol) {
                    case 'Juez':
                        include('paginasJuez.php');
                        break;
                    case 'Asesor':
                        include('paginasAsesor.php');
                        break;
                    case 'JuezAsesor':
                        include('paginasJuezAsesor.php');
                        break;
                    case 'Admin':
                        include('paginasAdmin.php');
                }}
        else{
            include ('configRegistro.php');
            if(isset($rol['resultado']))
            switch ($rol) {
                case 'Juez':
                    include('paginasJuez.php');
                    break;
                case 'Asesor':
                    include('paginasAsesor.php');
                    break;
                case 'JuezAsesor':
                    include('paginasJuezAsesor.php');
                    break;
                case 'Admin':
                    include('paginasAdmin.php');
        }
    }
}}