<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php"); // Redirige a la página de inicio de sesión si no está autenticado
    exit();
}

// Verifica si el usuario tiene permiso 'admin'
if ($_SESSION['permiso'] !== 'secundario') {
    // Si el usuario no tiene permiso 'admin', redirige a otra página o muestra un mensaje de error
    echo "<p>No tienes permisos para acceder a esta página.</p>";
    exit();
}

// HTML para la página de usuarios
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Xien App - Usuarios</title>
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
            max-width: 800px;
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
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .button {
            width: 18%;
            margin-right: 2%;
            padding: 15px;
            text-align: center;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }
        #green-button {
            background-color: #28a745; /* Verde */
        }
        #purple-button {
            background-color: #800080; /* Morado */
        }
        #orange-button {
            background-color: #fd7e14; /* Naranjado */
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
        <h2>Interfaz de Usuarios</h2>
        <a id="back-button" href="../dashboard.php">Regresar</a>
        <!-- Botones de acciones para usuarios -->
        <div class="button-container">
            <a id="green-button" class="button" href="registrar.php">Empresas</a>
            <a id="purple-button" class="button" href="suspender.php">Gestor</a>
            <a id="orange-button" class="button" href="editar.php">Editar</a>
        </div>
    </div>

</body>
</html>
