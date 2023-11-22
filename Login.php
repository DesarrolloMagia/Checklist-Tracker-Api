<?php
include 'connect.php'; // Incluye el archivo de conexión

// Procesamiento del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["login"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        try {
            // Consulta SQL para verificar el inicio de sesión con sentencia preparada
            $sql = "SELECT * FROM usuarios WHERE username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                // El usuario existe, verificar la contraseña
                if (password_verify($password, $result["password_hash"])) {
                    // Iniciar sesión y redirigir a Dashboard.php
                    session_start();
                    $_SESSION['username'] = $username;
                    header("Location: Dashboard.php");
                    exit();
                } else {
                    echo "Contraseña incorrecta";
                }
            } else {
                echo "Usuario no encontrado";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } elseif (isset($_POST["register"])) {
        // Lógica de registro
        $newUsername = $_POST["new_username"];
        $newPassword = password_hash($_POST["new_password"], PASSWORD_DEFAULT); // Hash de la contraseña

        try {
            $sql = "INSERT INTO usuarios (username, password_hash) VALUES (:newUsername, :newPassword)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':newUsername', $newUsername);
            $stmt->bindParam(':newPassword', $newPassword);
            $stmt->execute();

            echo "Usuario registrado correctamente";

            // Después de registrar, redirige a la página de inicio de sesión
            header("Location: Login.php");
            exit(); 
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Mi lista de Control</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="img js-fullheight" style="background-image: url(assets/bg.jpg);">
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">Mi lista de Control</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0" id="login-form-container">
                        <h3 class="mb-4 text-center">¿Tiene una cuenta?</h3>
                        <form action="#" class="signin-form" method="post">
                            <!-- Campos de inicio de sesión -->
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Usuario" name="username" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Contraseña" name="password" required>
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3" name="login">Iniciar sesión</button>
                            </div>
                        </form>
                        <p class="w-100 text-center">&mdash; O regístrese - &mdash;</p>
                        <div class="social d-flex text-center">
                            <a href="#register-form" class="px-2 py-2 mr-md-1 rounded" onclick="showRegisterForm()">Unirse ahora</a>
                        </div>
                    </div>
                    <!-- Formulario de registro oculto inicialmente -->
                    <div class="login-wrap p-0" id="register-form" style="display: none;">
                        <h3 class="mb-4 text-center">Create an account</h3>
                        <form action="#" class="signin-form" method="post">
                            <!-- Campos de registro -->
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Nuevo Usuario" name="new_username" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Nueva Contraseña" name="new_password" required>
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3" name="register">Registrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

    <script>
        // Función para mostrar el formulario de registro y ocultar el de inicio de sesión
        function showRegisterForm() {
            document.getElementById("login-form-container").style.display = "none";
            document.getElementById("register-form").style.display = "block";
        }
    </script>
</body>
</html>
