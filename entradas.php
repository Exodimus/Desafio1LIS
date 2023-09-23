<?php
include 'includes/templates/header.php';
include 'includes/templates/nav.php';
use classes\Entrada;
?>


<div class="container-fluid bg-light contenedor-main">
    <div class="row">
        <div class="row justify-content-center align-items-center" style="height: 40vh;">
            <div class="col-8 justify-content-center">
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $tipo = $_POST['tipo'];
                    $monto = $_POST['monto'];
                    $fecha = $_POST['fecha'];
                    $fotoFactura = $_FILES['factura'];

                    // Realiza el registro de la entrada en la base de datos utilizando la clase Entrada y la clase Database

                    // Crea una instancia de la clase Entrada y llama al método registrar
                    $entrada = new Entrada($tipo, $monto, $fecha, $fotoFactura);
                    $registroExitoso = $entrada->registrar();

                    if ($registroExitoso) {
                        echo 'success'; // Devuelve 'success' en caso de éxito
                    } else {
                        echo 'error'; // Devuelve 'error' en caso de error
                    }
                } else {
                    echo 'Método no permitido';
                }
                ?>
                <form action="" id="transacciones" method="POST">
                    <div class="mb-3 dashboard">
                        <label for="tipoEntrada" class="form-label fw-bold lblAct">Tipo de Entrada</label>
                        <input type="text" class="form-control" id="tipoEntrada" required>

                        <label for="monto" class="form-label fw-bold lblAct">Monto a depositar</label>
                        <input type="number" min="1" class="form-control" id="monto" required>

                        <label for="fecha" class="form-label fw-bold lblAct">Fecha</label>
                        <input type="date" class="form-control" id="fecha" required>

                        <label for="fotoFactura" class="form-label fw-bold lblAct">Subir Foto de Factura</label>
                        <input type="file" class="form-control" id="fotoFactura" accept="image/*" required>

                        <button type="submit" id="enviar" onclick="transactControl(entrada)" class="btn btn-primary depositar mt-3 bg-success">Enter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="mensaje" class="alert" role="alert" style="display: none;"></div>

<?php include 'includes/templates/footer.php'; ?>
