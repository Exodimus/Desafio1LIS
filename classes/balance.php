<?php 
namespace classes;
require('database.php');
use mysqli;

use Exception;

class Balance {
 
    
    public function _construct(){
    
    }
    public function calcularBalance($inicio,$final) {
                // Crear una instancia de la clase Database
        $database = new Database();
        $conexion = $database->createConnection();
        if ($conexion->connect_error) {
            throw new Exception("Error en la conexión a la base de datos: " . $conexion->connect_error);
        }
        
        $sql="call gen_balance_general_fecha('".$inicio."','".$final."') ";
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