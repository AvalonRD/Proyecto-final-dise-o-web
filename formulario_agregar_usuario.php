<?php include('../recursos/encabezado.php'); ?>

<div id="contenido">
    <div id="login">
        <div id="formularioValidacion">
            <h2>Crear usuario tipo admin</h2>
            <form action="salvar_admin.php" method="post"> <!-- Cambiado a POST -->
                <div class="form-group">
                    <label for="usuario">Usuario:</label>
                    <input type="text" id="usuario" name="usuario" required>
                </div>
                <div class="form-group">
                    <label for="clave">Contraseña:</label> <!-- Cambiado a "Contraseña" -->
                    <input type="password" id="clave" name="clave" maxlength="8" required> <!-- Cambiado a tipo "password" -->
                </div>
                <button type="submit">Salvar</button>
            </form>
        </div>
    </div>
</div>

<?php include('../recursos/pie_pagina.php'); ?>
