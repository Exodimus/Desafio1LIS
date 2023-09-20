<?php 
class Login {
    private $usuario;
    private $contrasena;

    public function __construct($usuario, $contrasena) {
        $this->usuario = $usuario;
        $this->contrasena = $contrasena;
    }

    public function autenticar() {
        // Lógica para autenticar al usuario aquí
        // Verificar si las credenciales son válidas
        if ($this->usuario === "usuario" && $this->contrasena === "contrasena")
            return true; // Autenticación exitosa

        // else {
        //     return false; // Autenticación fallida
        // }
    }
}

?>