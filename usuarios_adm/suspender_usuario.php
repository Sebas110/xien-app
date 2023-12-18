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

// Obtener el ID del usuario desde la solicitud GET
$id = $_GET['id'];

// Consulta SQL para actualizar el estado del usuario a "suspendido"
$sql = "UPDATE usuarios SET estado = 'suspendido' WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    // Devolver una respuesta exitosa
    echo "Usuario suspendido con éxito";
} else {
    // Devolver un mensaje de error si la actualización falla
    echo "Error al suspender el usuario: " . $conn->error;
}

// Cierra la conexión
$conn->close();
?>
