<?php
include 'includes/templates/header.php';
include 'includes/templates/nav.php';
require 'classes/entradas.php';
use classes\Entrada;
?>
<?php
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipoEntrada'];
    $monto = $_POST['monto'];
    $fecha = $_POST['fecha'];
    
    // Obtener la ruta completa al archivo temporal en el servidor
    $rutaArchivoTemporal = $_FILES['fotoFactura']['tmp_name'];

    // Realiza el registro de la entrada en la base de datos utilizando la clase Entrada y la clase Database

    // Crea una instancia de la clase Entrada y llama al método registrar
    $entrada = new Entrada($tipo, $monto, $fecha, $rutaArchivoTemporal);
    $registroExitoso = $entrada->registrar();

    if ($registroExitoso) {
        $mensaje = 'La entrada se registró exitosamente.';
        $claseAlerta = 'alert-success';
    } else {
        $mensaje = 'Error al registrar la entrada.';
        $claseAlerta = 'alert-danger';
    }
}
?>
<div class="container-fluid bg-light contenedor-main">
    <div class="row">
        <div class="row justify-content-center align-items-center" style="height: 40vh;">
            <div class="col-8 justify-content-center">
                <form action="" id="transacciones" method="POST" enctype="multipart/form-data">
                    <div class="mb-3 dashboard">
                        <label for="tipoEntrada" class="form-label fw-bold lblAct">Tipo de Entrada</label>
                        <input type="text" class="form-control" id="tipoEntrada" name="tipoEntrada" required>

                        <label for="monto" class="form-label fw-bold lblAct">Monto a depositar</label>
                        <input type="number" min="1" class="form-control" id="monto" name="monto" required>

                        <label for="fecha" class="form-label fw-bold lblAct">Fecha</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" required>

                        <label for="fotoFactura" class="form-label fw-bold lblAct">Subir Foto de Factura</label>
                        <input type="file" class="form-control" id="fotoFactura" name="fotoFactura" accept="image/*" required>

                        <button type="submit" id="enviar" onclick="transactControl('entradas')" class="btn btn-primary depositar mt-3 bg-success">Enviar</button>
                    </div>
                </form>
                <?php if ($mensaje): ?>
                    <div class="alert <?php echo $claseAlerta; ?>" id="mensaje" role="alert" style="display:block;">
                        <?php echo $mensaje; ?>
                    </div>
                    <script>
                    function ocultarMensaje() {
                        var mensaje = document.getElementById('mensaje');
                        console.log(mensaje.style.display === 'block');
                        if (mensaje.style.display === 'block') {
                            setTimeout(() => {
                                mensaje.style.display = 'none';
                            }, 3000); // Cambia 3000 a la cantidad de milisegundos que desees (3 segundos en este ejemplo)
                            
                        }
                    }

                    // Llama a la función para ocultar el mensaje
                    ocultarMensaje();
                    </script>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/templates/footer.php'; ?>
