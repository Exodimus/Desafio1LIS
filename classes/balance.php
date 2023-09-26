<?php 
namespace classes;
use mysqli;
use Exception;
require('database.php');
class Balance {
    private $fini;
    private $ffini;
    private $matriz;
    
    public function _construct($fini,$ffini){
        $this->fini=$fini;
        $this->ffini=$ffini;
    }
    public function calcularBalance($finicio,$ffinal) {
                // Crear una instancia de la clase Database
        $database = new Database();
    
        // Obtener una conexión a la base de datos
        $conexion = $database->createConnection();
    
        // Verificar la conexión
        if ($conexion->connect_error) {
            throw new Exception("Error en la conexión a la base de datos: " . $conexion->connect_error);
        }
        $sql="call gen_balance_general_fecha('2023-09-01','2023-09-30') ";
        $resultado=$conexion->query($sql);
        
                        // Verificar si se encontró un usuario con las credenciales proporcionadas
        if ($resultado->num_rows >0) {
            
           return $resultado->fetch_all();
            // Cierre la conexión a la base de datos
            $database->closeConnection($conexion);
        }
                // Cierre la conexión a la base de datos
        $database->closeConnection($conexion);
        return "No entro"; 
        
    }
}

?>