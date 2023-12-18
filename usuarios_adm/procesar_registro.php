<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "usuario";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];
    $permiso = $_POST['permiso'];
    $estado = $_POST['estado'];
    $nombre = $_POST['nombre'];
    $creador = $_SESSION['username'];
    // Consulta SQL para insertar el nuevo usuario en la tabla
    $sql = "INSERT INTO usuarios (creador,nombre_usuario, contrasena, estado, permiso, nombre) VALUES ('$creador','$username', '$password', '$estado', '$permiso','$nombre')";;

    if ($conn->query($sql) === TRUE) {
        // Redirigir a la página de usuarios después de procesar el registro
        header("Location: usuarios.php");
        exit();
    } else {
        echo "Error al insertar el usuario: " . $conn->error;
    }
} else {
    // Si no es una solicitud POST, redirigir a la página principal
    header("Location: ../index.php");
    exit();
}
$conn->close();
?>
