<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php"); // Redirige a la página de inicio de sesión si no está autenticado
    exit();
}

// HTML para la página del panel de control
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Xien App</title>
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
            margin-top: 20px;
        }
        .button {
            width: 48%; /* Ajusta el ancho según tus preferencias */
            padding: 15px;
            text-align: center;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }
        #blue-button {
            background-color: #007bff; /* Azul */
        }
        #purple-button {
            background-color: #800080; /* Morado */
        }
    </style>
</head>
<body>

    <header>
        <a id="home-button" href="dashboard.php">Xien App</a>
        <div>
            <span>Bienvenido, <?php echo $_SESSION['username']; ?></span>
            <a href="logout.php">Cerrar Sesión</a>
        </div>
    </header>

    <div class="container">
        <!-- Contenido del panel de control según los permisos -->
        <?php
        switch ($_SESSION['permiso']) {
            case 'admin':
                echo "<h2>Interfaz de Administrador</h2>";
                echo '<div class="button-container">';
                echo '<a id="blue-button" class="button" href="usuarios_adm/usuarios.php">Usuarios</a>';
                echo '<a id="purple-button" class="button" href="perfil.php">Perfil</a>';
                echo '</div>';
                break;
            case 'primario':
                echo "<h2>Interfaz de Usuario Primario</h2>";
                // Contenido específico para usuarios primarios
                break;
            case 'secundario':
                echo "<h2>Interfaz de Usuario Secundario</h2>";
                echo '<a id="blue-button" class="button" href="usuarios_sec/usuarios.php">Usuarios</a>';
                // Contenido específico para usuarios secundarios
                break;
            default:
                echo "<p>No se encontraron permisos válidos.</p>";
                break;
        
        }
        ?>
    </div>

</body>
</html>
