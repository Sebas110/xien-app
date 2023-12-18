<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php"); // Redirige a la página de inicio de sesión si no está autenticado
    exit();
}

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

// Lógica para editar el usuario
if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    // Consulta SQL para obtener la información del usuario
    $sql = "SELECT id, nombre, nombre_usuario, permiso, contrasena FROM usuarios WHERE id = $id_usuario";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    } else {
        echo "Usuario no encontrado";
        exit();
    }
} else {
    echo "ID de usuario no proporcionado";
    exit();
}

// Lógica para actualizar la información del usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_nombre = $_POST['nuevo_nombre'];
    $nuevo_nombre_usuario = $_POST['nuevo_nombre_usuario'];
    $nuevo_contrasena = $_POST['nuevo_contrasena'];
    $nuevo_permiso = $_POST['nuevo_permiso'];
    // Agrega más campos según sea necesario para la edición

    // Consulta SQL para actualizar la información del usuario
    $sql_update = "UPDATE usuarios SET 
    nombre = '$nuevo_nombre', 
    nombre_usuario = '$nuevo_nombre_usuario', 
    contrasena = '$nuevo_contrasena', 
    permiso = '$nuevo_permiso' 
    WHERE id = $id_usuario";

    if ($conn->query($sql_update) === TRUE) {
        echo "Información del usuario actualizada correctamente.";
    } else {
        echo "Error al actualizar la información del usuario: " . $conn->error;
    }
}

if ($_SESSION['permiso'] !== 'admin') {
    // Si el usuario no tiene permiso 'admin', redirige a otra página o muestra un mensaje de error
    echo "<p>No tienes permisos para acceder a esta página.</p>";
    exit();
}
// HTML para la página de edición del usuario
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Xien App - Editar Usuario</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: white;
            padding: 1em;
            text-align: left;
            display: flex;
            justify-content: space-between;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        #home-button {
            background-color: #333;
            color: white;
            padding: 10px;
            text-decoration: none;
            border-radius: 4px;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }
        button {
            background-color: #007bff; /* Azul */
            color: white;
            padding: 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        #back-button {
            background-color: #555;
            color: white;
            padding: 10px;
            text-decoration: none;
            border-radius: 4px;
            margin-right: 10px;
        }
    </style>
</head>
<body>

    <header>
        <a id="home-button" href="../dashboard.php">Xien App</a>
        <div>
            <span>Bienvenido, <?php echo $_SESSION['username']; ?></span>
            <a href="../logout.php">Cerrar Sesión</a>
        </div>
    </header>

    <div class="container">
        <h2>Editar Usuario</h2>
        <a id="back-button" href="editar.php">Regresar</a>
        <form action="editar_usuario.php?id=<?php echo $id_usuario; ?>" method="POST">
            <label for="nuevo_nombre">Empresa::</label>
            <input type="text" id="nuevo_nombre" name="nuevo_nombre" value="<?php echo $usuario['nombre']; ?>" required>
            
            <label for="nuevo_nombre_usuario">Usuario:</label>
            <input type="text" id="nuevo_nombre_usuario" name="nuevo_nombre_usuario" value="<?php echo $usuario['nombre_usuario']; ?>" required>

            <label for="nuevo_contrasena">Contraseña:</label>
            <input type="text" id="nuevo_contrasena" name="nuevo_contrasena" value="<?php echo $usuario['contrasena']; ?>" required>
            
            <label for="nuevo_permiso">Permiso:</label>
            <select id="nuevo_permiso" name="nuevo_permiso" required>
                <option value="admin">Admin</option>
                <option value="primario">Primario</option>
                <option value="secundario">Secundario</option>
            </select>


            <!-- Agrega más campos según sea necesario para la edición -->

            <button type="submit">Guardar Cambios</button>
        </form>
    </div>

</body>
</html>

<?php
// Cierra la conexión
$conn->close();
?>
