<?php 
namespace classes;
use mysqli;
use Exception;
require('database.php');
class Login {
    private $usuario;
    private $contrasena;
    private $nusuario;
    public function __construct($usuario, $contrasena) {
        $this->usuario = $usuario;
        $this->contrasena = $contrasena;
    }

    public function autenticar() {
        // Crear una instancia de la clase Database
        $database = new Database();
        
        // Obtener una conexión a la base de datos
        $conexion = $database->createConnection();
    
        // Verificar la conexión
        if ($conexion->connect_error) {
            throw new Exception("Error en la conexión a la base de datos: " . $conexion->connect_error);
        }
    
        // Escapar los valores de usuario y contraseña para evitar SQL injection
        $usuario = $conexion->real_escape_string($this->usuario);
        $contrasena = $conexion->real_escape_string($this->contrasena);
    
        // Consulta SQL para buscar al usuario en la base de datos
        $sql = "SELECT * FROM usuario WHERE usr_nombre = '$usuario' AND usr_password = '$contrasena'";
    
        // Ejecutar la consulta
        $resultado = $conexion->query($sql);
    
        // Verificar si se encontró un usuario con las credenciales proporcionadas
        if ($resultado->num_rows === 1) {
            // Cierre la conexión a la base de datos
            $database->closeConnection($conexion);
            return true; // Autenticación exitosa
        }
    
        // Cierre la conexión a la base de datos
        $database->closeConnection($conexion);
        return false; // Autenticación fallida
    }
    
    public function obtener_usuario($clave){
                // Crear una instancia de la clase Database
        $database = new Database();
    
        // Obtener una conexión a la base de datos
        $conexion = $database->createConnection();
    
        // Verificar la conexión
        if ($conexion->connect_error) {
            throw new Exception("Error en la conexión a la base de datos: " . $conexion->connect_error);
        }
        $sql="select dus_nombre from usuario inner join datos_usuario on usr_id=dus_usuario where usr_nombre='".$clave."'";
        $resultado=$conexion->query($sql);
        
                // Verificar si se encontró un usuario con las credenciales proporcionadas
        if ($resultado->num_rows === 1) {
            // Cierre la conexión a la base de datos
            $database->closeConnection($conexion);
            return $resultado->fetch_array()['dus_nombre']; // Autenticación exitosa
        }
                // Cierre la conexión a la base de datos
        $database->closeConnection($conexion);
        return ""; // Autenticación fallida
    }
    
}

?>