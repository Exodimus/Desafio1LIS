<?php 
namespace classes;
require('database.php');
use mysqli;

use Exception;

class Balance {
    private $fini;
    private $ffini;
   
    
    public function _construct($fini,$ffini){
        $this->fini=$fini;
        $this->ffini=$ffini;
    }
    public function obtener_datos(){

        return $this->calcularBalance();
    }
    public function calcularBalance() {
                // Crear una instancia de la clase Database
        $database = new Database();
        $conexion = $database->createConnection();
        if ($conexion->connect_error) {
            throw new Exception("Error en la conexión a la base de datos: " . $conexion->connect_error);
        }
        $sql="call gen_balance_general_fecha('".$GLOBALS['finicio']."','".$GLOBALS['ffinal']."') ";
        $resultado=$conexion->query($sql);
        
                        // Verificar si se encontró un usuario con las credenciales proporcionadas
        if ($resultado->num_rows >0) {
            
           return $resultado->fetch_all();
            // Cierre la conexión a la base de datos
            $database->closeConnection($conexion);
        }
                // Cierre la conexión a la base de datos
        $database->closeConnection($conexion);
        return ""; 
        
    }
}
?>