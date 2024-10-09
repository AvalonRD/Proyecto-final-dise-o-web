<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET") {
        // Capturar las variables enviadas por POST o GET
        $id_usuario = $_REQUEST["id_usuario"];
    }
  
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <h1>Modificar Usuario</h1>

    <form id="form-modificar" style="display:none;" action='actualizar_usuario.php'>
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario"  required><br><br>

        <label for="clave">Clave:</label>
        <input type="text" id="clave" name="clave"   required><br><br>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre"    required><br><br>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo"  required><br><br>

        <input type="hidden" id="id_usuario" name="id_usuario"  value='<?php echo $id_usuario ?>' required>

        <button type="submit">Modificar Usuario</button>
    </form>

    <p id="mensaje" style="color: green; display: none;">Usuario modificado exitosamente.</p>
    <p id="error" style="color: red; display: none;"></p>

    <script>
        $(document).ready(function() {
            // Cargar usuario
            function cargar_usuario(){
                var id_usuario = <?php echo $id_usuario ?>;
                $.ajax({
                    url: 'cargar_usuario.php',
                    type: 'GET',
                    data: { id_usuario: id_usuario },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.error) {
                            $("#error").text(data.error).show();
                        } else {
                            $("#usuario").val(data.usuario);
                            $("#clave").val(data.clave);
                            $("#nombre").val(data.nombre);
                            $("#correo").val(data.correo);
                            $("#form-modificar").show();
                            $("#error").hide();
                        }
                    }
                });
            }

            cargar_usuario();

                        // Modificar usuario
                        $("#form-modificar").submit(function(e) {
                e.preventDefault(); // Evitar el comportamiento por defecto del formulario

                // Obtener los valores del formulario
                var id_usuario = $("#id_usuario").val();
                var usuario = $("#usuario").val();
                var clave = $("#clave").val();
                var nombre = $("#nombre").val();
                var correo = $("#correo").val();

                // Enviar los datos usando AJAX
                
                $.ajax({
                        url: 'actualizar_usuario.php',
                        type: 'POST',
                        data: {
                            id_usuario: id_usuario,
                            usuario: usuario,
                            clave: clave,
                            nombre: nombre,
                            correo: correo
                        },
                        success: function(response) {
                            var data;
                            try {
                                data = JSON.parse(response); // Parsear la respuesta como JSON
                            } catch (e) {
                                $("#error").text("Error en la respuesta del servidor.").show();
                                return;
                            }
                            
                            if (data.success) {
                                $("#mensaje").show();
                                $("#error").hide();
                            } else {
                                $("#error").text(data.error || "Error desconocido.").show();
                                $("#mensaje").hide();
                            }
                        },
                        error: function() {
                            $("#error").text("Ocurrió un error en la solicitud.").show();
                        }
                    });
            });


        });
    </script>

</body>
</html>
