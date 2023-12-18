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
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $tipo_documento = $_POST['tipo_documento'];
    $documento = $_POST['documento'];
    $arl = $_POST['arl'];
    $representante = $_POST['representante'];
    $estado = $_POST['estado'];
    $permiso = $_POST['permiso'];

    // Obtener el nombre de usuario del creador de la sesión
    session_start();
    $creador = $_SESSION['username'];

    // Consulta SQL para insertar el nuevo usuario en ambas tablas
    $sql = "INSERT INTO usuario_cliente (creador, nombre, usuario, contrasena, tipo_documento, documento, arl, representante) 
            VALUES ('$creador', '$nombre', '$usuario', '$contrasena', '$tipo_documento', '$documento', '$arl', '$representante')";

    if ($conn->query($sql) === TRUE) {
        // Insertar en la segunda tabla
        $sql2 = "INSERT INTO usuarios (creador, nombre_usuario, contrasena, estado, permiso, nombre) 
                 VALUES ('$creador', '$usuario', '$contrasena', '$estado', '$permiso', '$nombre')";

        if ($conn->query($sql2) === TRUE) {
            // Redirigir a la página de usuarios después de procesar el registro
            header("Location: usuarios.php");
            exit();
        } else {
            echo "Error al insertar en la tabla 'usuarios': " . $conn->error;
        }
    } else {
        echo "Error al insertar en la tabla 'usuario_cliente': " . $conn->error;
    }
} else {
    // Si no es una solicitud POST, redirigir a la página principal
    header("Location: ../index.php");
    exit();
}

$conn->close();
?>

