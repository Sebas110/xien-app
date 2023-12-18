<?php
session_start();

// Verifica si el usuario está autenticado y tiene permisos de administrador
if (!isset($_SESSION['username']) || $_SESSION['permiso'] !== 'admin') {
    header("Location: ../index.php"); // Redirige si no está autenticado o no tiene permisos de administrador
    exit();
}

if ($_SESSION['permiso'] !== 'admin') {
    // Si el usuario no tiene permiso 'admin', redirige a otra página o muestra un mensaje de error
    echo "<p>No tienes permisos para acceder a esta página.</p>";
    exit();
}
// HTML para la página de registro de usuarios
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Xien App - Registrar Usuario</title>
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
            background-color: #28a745; /* Verde */
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
        <a id="back-button" href="usuarios.php">Regresar</a>
        <h2>Registrar Nuevo Usuario</h2>
        <form action="procesar_registro.php" method="post">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="username">Nombre de Usuario:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>


            <label for="estado">Estado:</label>
            <select id="estado" name="estado" required>
                <option value="activo">activo</option>
                <option value="suspendido">suspendido</option>
            </select>

            <label for="permiso">Permiso:</label>
            <select id="permiso" name="permiso" required>
                <option value="primario">Primario</option>
                <option value="secundario">Secundario</option>
            </select>


            <button type="submit">Registrar Usuario</button>
        </form>
    </div>
</body>
</html>
