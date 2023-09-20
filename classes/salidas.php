<?php 
class Salida {
    private $tipo;
    private $monto;
    private $fecha;
    private $factura;

    public function __construct($tipo, $monto, $fecha, $factura) {
        $this->tipo = $tipo;
        $this->monto = $monto;
        $this->fecha = $fecha;
        $this->factura = $factura;
    }

    public function registrar() {
        // Lógica para registrar una salida en la base de datos o en otro sistema
    }
}

?>