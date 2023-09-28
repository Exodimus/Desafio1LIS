  <?php
include 'includes/templates/header.php';
include 'includes/templates/nav.php';

?>
  <div class="container-fluid bg-light contenedor-main">
    <div class="col-12 px-0 bg-gray">
      <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
          <!-- Botón para mostrar el balance y redireccionar -->
          <a class="navbar-brand fw-bold" href="balance.html">Mostrar balance</a>
        </div>
      </nav>
      
    </div>
    <div class="row h-100">
        <div class="col-6 border text-center align-items-center">
            <h2 class="pb-4">Historial de transacciones</h2>
            <ul class="list-group transacList">
              </ul>
        </div>
        <div class="col-6 border text-center">
            <h2 class="pb-4">Gráfico de tipo de transacciones</h2>
            <canvas id="acquisitions"></canvas>
        </div>
    </div>
    <?php include 'includes/templates/footer.php';?>