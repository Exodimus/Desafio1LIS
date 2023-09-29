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
$GLOBALS['finicio']=$_SESSION['fini'];
$GLOBALS['ffinal']=$_SESSION['ffini'];
$genBalance=new balance($GLOBALS['finicio'],$GLOBALS['ffinal']);
$data=$genBalance->calcularBalance();

$imprimir->addpage();// First table: output all columns

$imprimir->cabecera2($GLOBALS['finicio'], $GLOBALS['ffinal']);

$imprimir->SetWidths(array(40, 50, 30, 30,40));
$imprimir->cabecera();
$imprimir->SetFont('Times', '', 9);
if ($data<>"")
{
   
    foreach ($data as $valor)
    {
        $imprimir->Row($valor);
    }
}
ob_get_length();
$imprimir->Output();  
}
        
}

use classes\ImprimirPdf;
$iimp=new ImprimirPdf();
$iimp->imp();


