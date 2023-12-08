<?php
session_start()?>
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
    </style>
</head>

<body>
<?php
include('logo.php');
?>

<div id="register" class="login-tab" >
    <h2>Registrarse</h2>
    <form method="post" autocomplete="off" action="pagPrincipal.php">
        <label for="rol">Rol:</label>
        <select id="rol" name="rol" required>
            <option value="Juez">Juez</option>
            <option value="Asesor">Asesor</option>
        </select><br><br>
        <label for="nombresR">Nombre(s):</label>
        <input type="text" id="nombresR" name="nombresR" required><br><br>
        <label for="apellidoPR">Apellido Paterno:</label>
        <input type="text" id="apellidoPR" name="apellidoPR" required><br><br>
        <label for="apellidoMR">Apellido Materno:</label>
        <input type="text" id="apellidoMR" name="apellidoMR" required><br><br>
        <label for="correoR">Correo:</label>
        <input type="email" id="correoR" name="correoR" required><br><br>
        <label for="contrasenaR">Contraseña:</label>
        <input type="password" id="contrasenaR" name="contrasenaR" required><br><br>
        <label for="confContrasenaR">Confirma la contraseña:</label>
        <input type="password" id="repiteContrasenaR" name="repiteContrasenaR" required><br><br>
        <label for="institucion">Institución:</label>
        <input type="text" id="institucion" name="institucion" required><br><br>

        <label for="estado">Estado de la institucion:</label>
        <input type="text" id="estado" name="estado">

        <label for="municipio">Municipio de la institucion:</label>
        <input type="text" id="municipio" name="municipio">

        <label for="colonia">Colonia de la institucion:</label>
        <input type="text" id="colonia" name="colonia">

        <label for="calle">Calle de la institucion:</label>
        <input type="text" id="calle" name="calle">

        <label for="numero">Número de la institucion:</label>
        <input type="number" id="numero" name="numero">

        <label for="codigo_postal">Código Postal de la institucion:</label>
        <input type="text" id="codigo_postal" name="codigo_postal">

        <label for="nivelAcademico" id="labelNivelAcademico">Nivel Académico:</label>
        <select id="nivelAcademico" name="nivelAcademico" required>
            <option value="Primaria">Primaria</option>
            <option value="Secundaria">Secundaria</option>
            <option value="Bachillerato">Bachillerato</option>
            <option value="Profesional">Profesional</option>
        </select><br><br>
        <input type="hidden" name="formulario" value="registro">

        <input type="submit" id="submitR" value="Registrarse">
    </form>
</div>
<script>
        function aparecerNivelAcademico() {
        var rol = document.getElementById('rol');
        var seleccionNivelAcademico = document.getElementById('nivelAcademico');
        var lblNivelAcademico = document.getElementById('labelNivelAcademico');
if (rol.value === 'Juez' || rol.value === 'JuezAsesor') {
    seleccionNivelAcademico.style.display = 'block';
    lblNivelAcademico.style.display = 'block';
} else {
    seleccionNivelAcademico.style.display = 'none';
    lblNivelAcademico.style.display = 'none';
}
}
document.getElementById('rol').addEventListener('change', aparecerNivelAcademico);
        aparecerNivelAcademico();
</script>
</body>
</html>

