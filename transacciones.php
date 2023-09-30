<?php
include 'includes/templates/header.php';
include 'includes/templates/nav.php';
require 'classes/database.php';
use classes\Database;

try {
    // Crear una instancia de la clase Database para la conexión
    $database = new Database();

    // Realizar la conexión
    $conexion = $database->createConnection();

    // Comprobar la conexión
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    // Consulta para obtener las entradas
    $consulta_entradas = "SELECT * FROM entrada";
    $result_entradas = $conexion->query($consulta_entradas);

    // Consulta para obtener las salidas
    $consulta_salidas = "SELECT * FROM salida";
    $result_salidas = $conexion->query($consulta_salidas);

    // Cierra la conexión
    $database->closeConnection($conexion);
} catch (Exception $e) {
    // Manejar errores de conexión aquí
    echo "Error: " . $e->getMessage();
}
?>

<div class="container-fluid bg-light contenedor-main">
    <div class="col-12 px-0 bg-gray">
        <nav class="navbar navbar-light bg-light">
        </nav>
    </div>
    <div class="row h-100">
        <div class="col-6 border text-center align-items-center">
            <h2 class="pb-4">Historial de transacciones</h2>
            <!-- Agrega este formulario antes de mostrar la lista de transacciones -->
            <form action="" method="GET" class="mb-3">
                <label for="filtroTipo">Filtrar por:</label>
                <select name="filtroTipo" id="filtroTipo" class="form-select">
                    <option value="todos">Todos</option>
                    <option value="entradas">Entradas</option>
                    <option value="salidas">Salidas</option>
                </select>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </form>

            <!-- Mostrar entradas o salidas según el filtro -->
            <ul class="list-group transacList" style="height: 400px; overflow-y: auto;">
                <?php
                // Verificar el filtro seleccionado
                $filtroTipo = isset($_GET['filtroTipo']) ? $_GET['filtroTipo'] : 'todos';

                // Mostrar entradas en azul
                while ($fila = $result_entradas->fetch_assoc()) {
                    if ($filtroTipo === 'entradas' || $filtroTipo === 'todos') {
                        echo '<li class="list-group-item text-primary">';
                        echo '<i class="bi bi-arrow-up"></i> Entrada<br>';
                        echo 'Fecha: ' . $fila['ent_fecha'] . '<br>';
                        echo 'Tipo: ' . $fila['ent_tipo'] . '<br>';
                        echo 'Monto: ' . $fila['ent_monto'];
                        echo '</li>';
                    }
                }

                // Mostrar salidas en rojo
                while ($fila = $result_salidas->fetch_assoc()) {
                    if ($filtroTipo === 'salidas' || $filtroTipo === 'todos') {
                        echo '<li class="list-group-item text-danger">';
                        echo '<i class="bi bi-arrow-down"></i> Salida<br>';
                        echo 'Fecha: ' . $fila['sal_fecha'] . '<br>';
                        echo 'Tipo: ' . $fila['sal_tipo'] . '<br>';
                        echo 'Monto: ' . $fila['sal_monto'];
                        echo '</li>';
                    }
                }
                ?>
            </ul>

        </div>
        <!-- Agrega este bloque en tu HTML -->
        <div class="col-6 border text-center">
            <h2 class="pb-4">Gráfico de tipo de transacciones</h2>
            <canvas id="acquisitions"></canvas>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script>
    // Obtén los datos de PHP (puedes ajustar esto según tu estructura de datos)
    var entradasData = <?php echo json_encode($result_entradas->num_rows); ?>;
    var salidasData = <?php echo json_encode($result_salidas->num_rows); ?>;

    // Configura los datos para el gráfico
    var data = {
        labels: ['Entradas', 'Salidas'],
        datasets: [{
            data: [entradasData, salidasData],
            backgroundColor: ['#36A2EB', '#FF6384'],
            hoverBackgroundColor: ['#36A2EB', '#FF6384']
        }]
    };

    // Configura las opciones del gráfico
    var options = {
        responsive: true,
        maintainAspectRatio: false
    };

    // Obtén el contexto del lienzo
    var ctx = document.getElementById('acquisitions').getContext('2d');

    // Crea el gráfico de pastel
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: data,
        options: options
    });
</script>

<?php include 'includes/templates/footer.php'; ?>
