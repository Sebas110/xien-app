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

// Lógica para el buscador
if(isset($_GET['buscar'])) {
    $termino_busqueda = $_GET['buscar'];
    $sql = "SELECT id,nombre, nombre_usuario, permiso FROM usuarios WHERE nombre, LIKE '%$termino_busqueda%'";
} else {
    // Obtener todos los usuarios de la base de datos si no hay término de búsqueda
    $sql = "SELECT id,nombre, nombre_usuario, permiso FROM usuarios";
}

$result = $conn->query($sql);

if ($_SESSION['permiso'] !== 'admin') {
    // Si el usuario no tiene permiso 'admin', redirige a otra página o muestra un mensaje de error
    echo "<p>No tienes permisos para acceder a esta página.</p>";
    exit();
}
// HTML para la página de edición
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
            max-width: 1200px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: white;
        }
        input[type="text"] {
            padding: 10px;
            margin-bottom: 10px;
        }
        button {
            background-color: #007bff; /* Azul */
            color: white;
            padding: 10px;
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
        <a id="back-button" href="usuarios.php">Regresar</a>
        <h2>Editar Usuarios</h2>
        <form action="editar.php" method="GET">
            <label for="buscar">Buscar Usuario:</label>
            <input type="text" id="buscar" name="buscar" placeholder="Ingrese el nombre de usuario">
            <button type="submit">Buscar</button>
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Nombre de Usuario</th>
                <th>Permiso</th>
                <th>Acciones</th>
            </tr>
            <?php
            // Mostrar usuarios en la tabla
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['nombre']}</td>";
                echo "<td>{$row['nombre_usuario']}</td>";
                echo "<td>{$row['permiso']}</td>";
                echo "<td><a href='editar_usuario.php?id={$row['id']}'>Editar</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

</body>
</html>

<?php
// Cierra la conexión
$conn->close();
?>
