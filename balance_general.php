<?php
require('classes/balance.php');

include 'includes/templates/header.php';
include 'includes/templates/nav.php';
use classes\balance;
?>
<script>
  document.addEventListener("DOMContentLoaded", function() {
  document.getElementById("form_fechas").addEventListener('submit', validarFormulario); 
});
function validarFormulario(evento) {
  evento.preventDefault();
  
  var fini = document.getElementById('inicio').value;
  var ffin = document.getElementById('fin').value;
  var f1=fini.toString().split('-');
  let año1,mes1,dia1,año2,mes2,dia2;
  año1=f1[0];
  mes1=f1[1];
  dia1=f1[2];
  f1=ffin.toString().split('-');
   año2=f1[0];
  mes2=f1[1];
  dia2=f1[2];
  let b1=1;
  //PRIMERA VALIDACION
  if (año1==año2){
      if (mes1==mes2){
          if (dia1>dia2){
              b1=0;
          }
      }
      else{
          if (mes1>mes2){
              b1=0;
          }
      }
  }
  else
  {
      if (año1>año2){
          b1=0;
      }
  }
  var myModal = new bootstrap.Modal(document.getElementById('alerta_fecha'));
  if (b1==0){
    myModal.show();
      return;
  }
  else{
      this.submit();
  }

}

</script>
<div class="container-fluid bg-light contenedor-main">
    <div class="row">

  <form autocomplete="off" method="POST" name ="form_fechas" id="form_fechas">
    <div class="flex-row d-flex justify-content-center">
      <div class="col-lg-6 col-11 px-1">
          
        <div class="input-group input-daterange">
            <label class="ml-3 form-control-placeholder" id="linicio" for="inicio"> Fecha Inicio:&nbsp; </label>
          <input type="date" id="inicio" class="form-control" name="inicio" required>
          <span class="fa fa-calendar" id="fa-1"></span>
          
          <label class="ml-3 form-control-placeholder" id="lfin" for="fin"> Fecha Final:&nbsp; </label>
          <input type="date" id="fin" class="form-control" name="fin" required>
          <span class="fa fa-calendar" id="fa-2"></span>
          
        </div>         
      </div>
        <button type="submit" id="boton2"  class="btn btn-primary text-left mr-2">CALCULAR</button>  
    </div>
  </form>
  </div>
    <div class="container">
        <div class="row">
<?php 
  
  
  try{
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $fini=$_POST['inicio'];
      $ffini=$_POST['fin'];          
      $_SESSION['fini']=$fini;
      $_SESSION['ffini']=$ffini;

      $cbalance=new balance();
      $bal=$cbalance->calcularBalance($fini,$ffini);

      if ($bal==="")
      {}
      else{
          $i=0;
          $final=count($bal)-1;
          $saldo_anterior=$bal[0][4];
          $saldo_actual=$bal[$final][4];
          ?>
            <br>
            <hr class="my-4">
            <div class='container'>
                <div class="row">
                  <div class="col-sm"><a class="btn btn-primary" href="classes/ImprimirPdf.php" target="_blank" role="button">Generar PDF</a></div>
                    <div class="col-sm"><b>Saldo Anterior: </b><?php echo $saldo_anterior; ?></div>
                    <div class="col-sm"><b>Saldo Actual: </b><?php echo $saldo_actual; ?></div>
                </div>
            </div>
            <div>
                <br>
          <table class='table'>
          <thead>
              <tr>
          <th scope='col'>SALDO ANTERIOR</th>
          <th scope='col'>FECHA</th>
          <th scope='col'>ENTRADA(+)</th>
          <th scope='col'>SALIDA(-)</th>
          <th scope='col'>SALDO ACTUAL</th>
          </tr>
          </thead>
          <tbody>
          <?php

          foreach ($bal as $valor)
          {
              if ($i!=0){
                  if ($i==$final){
              echo "<tr class='table-primary'>";
              echo "<td><b>".$valor[0]. "</b></td>";
              echo "<td><b>".$valor[1]. "</b></td>";
              echo "<td><b>".$valor[2]. "</b></td>";
              echo "<td><b>".$valor[3]. "</b></td>";   
              echo "<td><b>".$valor[4]. "</b></td>";
              echo "</tr>";
                  }
                  else{
              echo "<tr>";
              echo "<td>".$valor[0]. "</td>";
              echo "<td>".$valor[1]. "</td>";
              echo "<td>".$valor[2]. "</td>";
              echo "<td>".$valor[3]. "</td>";   
              echo "<td>".$valor[4]. "</td>";
              echo "</tr>"; 
                  }

              }
          $i=$i+1;
          }
          ?>
         </tbody>
          </table>
          </div>
          <?php
          
      }
      }
    
  }
  catch (Exception $e)
  {
      echo 'Ha ocurrido el siguiente Error ' , $e->getMessage(),'\n';
  }

  

?>
        
            
        
    </div>
    
</div>

    <br><!-- comment -->
     <hr class="my-4">
<!-- Modal -->
<div class="modal fade" id="alerta_fecha" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="lbl_alerta_fecha">ERROR</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Fecha Final no puede ser mayor que fecha inicial
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<?php include 'includes/templates/footer.php'; ?>
