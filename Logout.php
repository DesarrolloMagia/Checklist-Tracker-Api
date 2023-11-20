<?php
// Inicia la sesión
session_start();

// Destruye la sesión
session_destroy();

// Redirige a la página de inicio de sesión
header("Location: Login.php");
exit();
?>
