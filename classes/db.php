<?php 
class Database
{
    const DBHOSTNAME = "localhost";
    const DBUSER = "root";
    const DBPASS = "";
    const DBDATABASE = "lisp1";
    const CHARSET = "utf8";

    public function createConnection(){
        $connection = new mysqli(self::DBHOSTNAME, self::DBUSER, self::DBPASS, self::DBDATABASE);

        // Verificar conexión
        if ($connection->connect_errno) {
            echo "Error en la conexión: " . $connection->connect_error;
        }
        
        return $connection;
    }

    public function closeConnection($connection){
        $connection->close();
    }
}
?>
