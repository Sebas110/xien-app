<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php"); // Redirige a la página de inicio de sesión si no está autenticado
    exit();
}


// Conéctate a tu base de datos (reemplaza los valores según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "usuario";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

// Consulta SQL para obtener la lista de usuarios
$sql = "SELECT id, nombre_usuario, contrasena, permiso, estado, nombre FROM usuarios";
$result = $conn->query($sql);

if ($_SESSION['permiso'] !== 'admin') {
    // Si el usuario no tiene permiso 'admin', redirige a otra página o muestra un mensaje de error
    echo "<p>No tienes permisos para acceder a esta página.</p>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Usuarios - Xien App</title>
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
            max-width: 1000px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-x: auto; /* Agregado para manejar barras de desplazamiento horizontal si la tabla es demasiado ancha */
        }
        #home-button {
            text-decoration: none;
            color: inherit;
            padding: 10px;
            border-radius: 4px;
            background-color: #333;
            color: white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn-container {
            display: flex;
            justify-content: flex-end;
        }
        .btn-green, .btn-yellow, .btn-red {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 5px;
        }
        .btn-yellow {
            background-color: #FFC107;
        }
        .btn-red {
            background-color: #FF5733;
        }
        .search-container {
            margin-bottom: 20px;
            display: flex; /* Cambiado a flex para alinear elementos horizontalmente */
        }
        .search-container input {
            padding: 8px;
            margin-right: 5px;
        }
        .search-container button {
            padding: 8px;
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
        <h2>Lista de Usuarios</h2>
        <div class="search-container">
            <form action="" method="get">
                <input type="text" name="search" placeholder="Buscar usuario..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button type="submit">Buscar</button>
                <a id="back-button" href="usuarios.php">Regresar</a>
            </form>
        </div>

        

        

        <?php
        // Verifica si la consulta se ejecutó correctamente
        if ($result === false) {
            echo '<p>Error en la consulta SQL: ' . $conn->error . '</p>';
        } else {
            // Verifica si hay resultados
            if ($result->num_rows > 0) {
                echo '<table>';
                echo '<tr><th>ID</th><th>Nombre</th><th>Usuario</th><th>Contraseña</th><th>Permiso</th><th>Estado</th><th>Acción</th></tr>';
                while ($row = $result->fetch_assoc()) {
                    // Filtra los resultados según la búsqueda
                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                        $searchTerm = $_GET['search'];
                        $match = false;

                        // Comprueba si el término de búsqueda coincide con algún dato del usuario
                        foreach ($row as $value) {
                            if (stripos($value, $searchTerm) !== false) {
                                $match = true;
                                break;
                            }
                        }

                        // Si no hay coincidencias, pasa al siguiente usuario
                        if (!$match) {
                            continue;
                        }
                    }

                    echo '<tr>';
                    echo '<td>' . $row['id'] . '</td>';
                    echo '<td>' . $row['nombre'] . '</td>';
                    echo '<td>' . $row['nombre_usuario'] . '</td>';
                    echo '<td>' . $row['contrasena'] . '</td>';
                    echo '<td>' . $row['permiso'] . '</td>';
                    echo '<td>' . $row['estado'] . '</td>';
                    echo '<td class="btn-container">';
                    echo '<button class="btn-green" onclick="activarUsuario(' . $row['id'] . ')">Activar</button>';
                    echo '<button class="btn-yellow" onclick="suspenderUsuario(' . $row['id'] . ')">Suspender</button>';
                    echo '<button class="btn-red" onclick="eliminarUsuario(' . $row['id'] . ')">Eliminar</button>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<p>No hay usuarios registrados en la base de datos.</p>';
            }
        }
        ?>

    </div>

    <!-- Agrega esta sección en el head de tu HTML -->
    <script>
        function activarUsuario(id) {
            if (confirm("¿Estás seguro de que deseas activar este usuario?")) {
                // Realiza una solicitud AJAX para activar al usuario
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Recarga la página después de la actualización
                        location.reload();
                    }
                };
                xhr.open("GET", "activar_usuario.php?id=" + id, true);
                xhr.send();
            }
        }
        function suspenderUsuario(id) {
            if (confirm("¿Estás seguro de que deseas suspender este usuario?")) {
                // Realiza una solicitud AJAX para suspender al usuario
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Recarga la página después de la actualización
                        location.reload();
                    }
                };
                xhr.open("GET", "suspender_usuario.php?id=" + id, true);
                xhr.send();
            }
        }
        function eliminarUsuario(id) {
            if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
                // Realiza una solicitud AJAX para eliminar al usuario
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Recarga la página después de la eliminación
                        location.reload();
                    }
                };
                xhr.open("GET", "eliminar_usuario.php?id=" + id, true);
                xhr.send();
            }
        }
    </script>

</body>
</html>
