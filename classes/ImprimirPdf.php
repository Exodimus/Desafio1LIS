<?php
namespace classes;
ob_start();
require('balance.php');
require('ImprimirTabla.php');
use classes\balance;
use ImprimirTabla;
class ImprimirPdf {
function imp()
{
session_start();
$imprimir=new ImprimirTabla();
$i=$_SESSION['fini'];
$f=$_SESSION['ffini'];
$genBalance=new balance();
$data=$genBalance->calcularBalance($i,$f);

$imprimir->addpage();// First table: output all columns
$imprimir->cabecera2($i, $f);

$imprimir->SetWidths(array(40, 50, 30, 30,40));



if ($data<>"")
{
   $i=0;
   $final=count($data)-1;
   $saldo1=$data[$final][0];
   $saldo2=$data[$final][4];
   $imprimir->colocar_saldo($saldo1,$saldo2);
    foreach ($data as $valor)
    {
        if ($i!=0){
            if ($i==1){
                $imprimir->cabecera();
            }
            if ($i==$final){
                $imprimir->SetFont('Times', 'B', 9);
                $imprimir->Row($valor); 
            }
           else{
               $imprimir->SetFont('Times', '', 9);
               $imprimir->Row($valor); 
           }
        }
        $i=$i+1;
    }
}
ob_get_length();
$imprimir->Output();  
}
        
}

use classes\ImprimirPdf;
$iimp=new ImprimirPdf();
$iimp->imp();


