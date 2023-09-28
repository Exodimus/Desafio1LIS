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

  <form autocomplete="off" method="POST" action="" id="form_fechas">
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
        <button type="button" id="boton2" onclick="this.form.submit()" class="btn btn-primary text-left mr-2">CALCULAR</button>  
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
        $GLOBALS['finicio']=$fini;
        $GLOBALS['ffinal']=$ffini; 
      $cbalance=new balance($GLOBALS['finicio'],$GLOBALS['ffinal']);
      $bal=$cbalance->calcularBalance();

      if ($bal==="")
      {}
      else{
          ?>
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
              echo "<tr>";
              echo "<td>".$valor[0]. "</td>";
              echo "<td>".$valor[1]. "</td>";
              echo "<td>".$valor[2]. "</td>";
              echo "<td>".$valor[3]. "</td>";   
              echo "<td>".$valor[4]. "</td>";
              echo "</tr>";
          }
          ?>
         </tbody>
          </table>
          </div>

        <div class='row'>
                <div class='col-2'></div>
                <div class='col-11'><a class="btn btn-primary" href="classes/ImprimirPdf.php" target="_blank" role="button">Generar PDF</a></div>
                <div class='col-2'></div>
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
    
</div>


<?php include 'includes/templates/footer.php'; ?>
