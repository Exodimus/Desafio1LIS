<?php
namespace classes;

use Exception; 

class Entrada {
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

        // Preparar la consulta SQL para insertar una entrada
        $sql = "INSERT INTO entrada (ent_tipo, ent_monto, ent_fecha, ent_factura) VALUES (?, ?, ?, ?)";

        // Preparar la sentencia
        $stmt = $conexion->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $conexion->error);
        }

        // Bind de los parámetros
        $stmt->bind_param("sds", $this->tipo, $this->monto, $this->fecha, $this->factura);

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
