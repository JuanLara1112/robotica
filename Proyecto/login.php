<div id="login" class="login-tab" >
    <h2>Iniciar sesión</h2>
    <form action="pagPrincipal.php" method="post">
        <label for="correoU">Correo:</label>
        <input type="email" id="correoU" name="correoU" required><br><br>
        <label for="contrasenaU">Contraseña:</label>
        <input type="password" id="contrasenaU" name="contrasenaU" required><br><br>
        <input type="hidden" name="formulario" value="login">
        <input type="submit" id="submitL" value="Iniciar sesión">
    </form>
    <br>
    <a href="registro.php"> ¿No estás registrado? Pulsa aquí </a>
</div>

