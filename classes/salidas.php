<?php
namespace classes;
require('database.php');
use Exception;

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
        // Crear una instancia de la clase Database
        $database = new Database();

        // Obtener una conexión a la base de datos
        $conexion = $database->createConnection();

        // Verificar la conexión
        if ($conexion->connect_error) {
            throw new Exception("Error en la conexión a la base de datos: " . $conexion->connect_error);
        }

        // Preparar la consulta SQL para insertar una salida
        $sql = "INSERT INTO salida (sal_tipo, sal_monto, sal_fecha, sal_factura) VALUES (?, ?, ?, ?)";

        // Preparar la sentencia
        $stmt = $conexion->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $conexion->error);
        }

        // Bind de los parámetros
        $stmt->bind_param("sdss", $this->tipo, $this->monto, $this->fecha, $this->factura);

        // Ejecutar la sentencia
        if ($stmt->execute()) {
            $stmt->close();
            $database->closeConnection($conexion);
            return true; // Registro exitoso
        }

        // Manejo de error
        $stmt->close();
        $database->closeConnection($conexion);
        throw new Exception("Error en el registro"); // Lanza una excepción en caso de error
    }
}
?>
