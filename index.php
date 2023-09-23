<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
</head>
<body class="bg-secondary">
    <div class="container box-shadow bg-light">
        <div class="row vh-100 justify-content-center align-items-center">
            <div class="col-4 w-50 d-none d-lg-block p-0"><img src="img/login.jpg" class="img-fluid"></div>
            <div class="col-8 col-lg-4 w-50">
                <?php
                 use classes\Login;

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $usuario = $_POST['user'];
                    $contrasena = $_POST['pass'];

                    // Crear una instancia de la clase Login
                    $login = new Login($usuario, $contrasena);

                    // Autenticar al usuario
                    if ($login->autenticar()) {
                        // Autenticación exitosa, redirigir al usuario a la página de inicio o a donde sea necesario
                        header('Location: entradas.php');
                        exit;
                    } else {
                        // Autenticación fallida, mostrar un mensaje de error
                        echo '<p class="text-danger">Autenticación fallida. Por favor, verifica tus credenciales.</p>';
                    }
                }
                ?>
                <form action="" method="POST">
                    <h1 class="text-center display-1 fw-lighter">Bienvenido</h1>
                    <div class="mb-3">
                        <label for="user" class="form-label lb-form">Usuario</label>
                        <input type="text" class="form-control" id="user" name="user">
                    </div>
                    <div class="mb-3">
                        <label for="pass" class="form-label lb-form">Contraseña</label>
                        <input type="password" class="form-control" id="pass" aria-describedby="passwordHelp" name="pass">
                        <div id="passwordHelp" class="form-text">No compartas tu contraseña con nadie.</div>
                    </div>
                    <button type="submit" class="btn btn-primary btnLogin">Enviar</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
