<?php
include 'includes/templates/header.php';
include 'includes/templates/nav.php';
require 'classes/salidas.php';
use classes\Salida;
?>

<div class="container-fluid bg-light contenedor-main">
    <div class="row">
        <div class="row justify-content-center align-items-center" style="height: 40vh;">
            <div class="col-8 justify-content-center">
                <?php
                $mensaje = '';
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $tipo = $_POST['tipoSalida'];
                    $monto = $_POST['montoSalida'];
                    $fecha = $_POST['fechaSalida'];
                    $fotoFactura = $_FILES['fotoFactura']['tmp_name'];

                    // Realiza el registro de la salida en la base de datos utilizando la clase Salida y la clase Database

                    // Crea una instancia de la clase Salida y llama al método registrar
                    $salida = new Salida($tipo, $monto, $fecha, $fotoFactura);
                    $registroExitoso = $salida->registrar();

                    if ($registroExitoso) {
                        $mensaje = 'La salida se registró exitosamente.';
                        $claseAlerta = 'alert-success';
                    } else {
                        $mensaje = 'Error al registrar la salida.';
                        $claseAlerta = 'alert-danger';
                    }
                }
                ?>
                <form action="" id="transacciones" method="POST" enctype="multipart/form-data">
                    <div class="mb-3 dashboard">
                        <label for="tipoSalida" class="form-label fw-bold lblAct">Tipo de Salida</label>
                        <input type="text" class="form-control" id="tipoSalida" name="tipoSalida" required>

                        <label for="montoSalida" class="form-label fw-bold lblAct">Monto</label>
                        <input type="number" min="1" class="form-control" id="montoSalida" name="montoSalida" required>

                        <label for="fechaSalida" class="form-label fw-bold lblAct">Fecha</label>
                        <input type="date" class="form-control" id="fechaSalida" name="fechaSalida" required>

                        <label for="facturaSalida" class="form-label fw-bold lblAct">Factura</label>
                        <input type="file" class="form-control" id="fotoFactura" name="fotoFactura" accept="image/*" required>

                        <button type="submit" id="enviar" class="btn btn-primary depositar mt-3 bg-success">Enviar</button>
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
