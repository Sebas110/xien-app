<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "usuario";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recupera las credenciales del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Consulta SQL para verificar las credenciales
$sql = "SELECT * FROM usuarios WHERE nombre_usuario = '$username' AND contrasena = '$password' AND estado != 'suspendido'";
$result = $conn->query($sql);

// Verifica si se encontró un usuario
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['permiso'] = $row['permiso'];
    header("Location: dashboard.php");
    exit();
} else {
    echo "Nombre de usuario o contraseña incorrectos.";
}


// Cierra la conexión
$conn->close();
?>
