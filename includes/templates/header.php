<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
 
    <link rel="stylesheet" href="css/style.css">
   
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap-responsive.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.js"></script>
<script rel="js\jsPDF-1.3.2\jspdf.js"></script>
    <title>Dashboard</title>
</head>
<body>
  <div class="container-fluid fondo" style="padding: 0 !important;">
    <nav class="navbar navbar-light" style="background: rgb(65, 136, 243) !important; padding: 0; ">
        <div class="container-fluid">
            <div class="navbar-brand p-2">            <b><?php 
            session_start(); echo "BIENVENIDO/A ".$_SESSION['nombre']; ?></b>
          </div>
          <a class="navbar-brand fw-bold" href="index.html">Cerrar sesión</a>
        </div>
    </nav>
  </div>