<?php
require('classes/balance.php');
include 'includes/templates/header.php';
include 'includes/templates/nav.php';
use classes\balance;
?>
<script>
    $(document).ready(function(){

$('.input-daterange').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    calendarWeeks : false,
    clearBtn: false,
    disableTouchKeyboard: false
});

});
   </script>
<div class="container-fluid bg-light contenedor-main">
    <div class="row">

  <form autocomplete="off" method="POST" action="">
    <div class="flex-row d-flex justify-content-center">
      <div class="col-lg-6 col-11 px-1">
          
        <div class="input-group input-daterange">
            <label class="ml-3 form-control-placeholder" id="linicio" for="inicio"> Fecha Inicio:&nbsp; </label>
          <input type="text" id="inicio" class="form-control text-left mr-2" name="inicio">
          
          <span class="fa fa-calendar" id="fa-1"></span>
          <label class="ml-3 form-control-placeholder" id="lfin" for="fin"> Fecha Final:&nbsp; </label>
          <input type="text" id="fin" class="form-control text-left ml-2" name="fin">
          <span class="fa fa-calendar" id="fa-2"></span>
        </div>         
      </div>
        <button type="submit" class="btn btn-primary text-left mr-2">CALCULAR</button>  
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

      $cbalance=new balance($fini,$ffini);
      $bal=$cbalance->calcularBalance($fini, $ffini);
      if ($bal==="")
      {}
      else{
          echo "<table class='table'>";
          echo "<thead><tr>";
          echo "<th scope='col'>SALDO ANTERIOR</th>";
          echo "<th scope='col'>FECHA</th>";
          echo "<th scope='col'>ENTRADA(+)</th>";
          echo "<th scope='col'>SALIDA(-)</th>";
          echo "<th scope='col'>SALDO ACTUAL</th>";
          echo "</tr></thead> <tbody>";
          foreach ($bal as $valor)
          {
              echo "<tr>";
              echo "<td>".$valor[0]. "</td>";
              echo "<td>".$valor[1]. "</td>";
              echo "<td>".$valor[2]. "</td>";
              echo "<td>".$valor[3]. "</td>";
              echo "<td>".$valor[4]. "</td>";
              echo "</tr>";
          }
          echo "</tbody></table>";
          echo "</div><div class='row'>";
          echo "<div class='col-2'></div>";
          echo "<div class='col-11'><button type='button' class='btn btn-primary text-left mr-2'>IMPRIMIR</button></div>";
          echo "<div class='col-2'></div>";
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
    
</div>
  

<?php include 'includes/templates/footer.php'; ?>
