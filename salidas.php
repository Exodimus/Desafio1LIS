<?php
include 'includes/templates/header.php';
include 'includes/templates/nav.php';
use classes\Salida;
?>

<div class="container-fluid bg-light contenedor-main">
    <div class="row">
        <div class="row justify-content-center align-items-center" style="height: 40vh;">
            <div class="col-8 justify-content-center">
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $tipo = $_POST['tipoSalida'];
                    $monto = $_POST['montoSalida'];
                    $fecha = $_POST['fechaSalida'];
                    $fotoFactura = $_FILES['facturaSalida'];

                    // Realiza el registro de la salida en la base de datos utilizando la clase Salida y la clase Database

                    // Crea una instancia de la clase Salida y llama al método registrar
                    $salida = new Salida($tipo, $monto, $fecha, $fotoFactura);
                    $registroExitoso = $salida->registrar();

                    if ($registroExitoso) {
                        echo 'success'; // Devuelve 'success' en caso de éxito
                    } else {
                        echo 'error'; // Devuelve 'error' en caso de error
                    }
                }
                ?>
                <form action="" id="transacciones" method="POST">
                    <div class="mb-3 dashboard">
                        <label for="tipoSalida" class="form-label fw-bold lblAct">Tipo de Salida</label>
                        <input type="text" class="form-control" id="tipoSalida" name="tipoSalida" required>

                        <label for="montoSalida" class="form-label fw-bold lblAct">Monto</label>
                        <input type="number" min="1" class="form-control" id="montoSalida" name="montoSalida" required>

                        <label for="fechaSalida" class="form-label fw-bold lblAct">Fecha</label>
                        <input type="date" class="form-control" id="fechaSalida" name="fechaSalida" required>

                        <label for="facturaSalida" class="form-label fw-bold lblAct">Factura</label>
                        <input type="file" class="form-control" id="facturaSalida" name="facturaSalida" accept="image/*" required>

                        <button type="submit" id="enviar" onclick="transactControl('salida')" class="btn btn-primary depositar mt-3 bg-success">Enter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/templates/footer.php'; ?>
