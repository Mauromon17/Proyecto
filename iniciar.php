<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dinoservicios";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $role = $_POST['role']; // El valor del select: 'trabajador' o 'cliente'

    try {
        // Crear una conexión a la base de datos usando PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Configurar el modo de error de PDO para que lance excepciones
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verificar el role seleccionado
        if ($role === 'trabajador') {
            // Consultar en la tabla empleados
            $stmt = $conn->prepare("SELECT * FROM empleados WHERE correo = :correo");
        } elseif ($role === 'cliente') {
            // Consultar en la tabla clientes
            $stmt = $conn->prepare("SELECT * FROM clientes WHERE correo = :correo");
        } else {
            // Role no válido (esto debería manejarse de manera adecuada en tu formulario)
            echo "Error: Role no válido.";
            exit;
        }

        // Bind de parámetros
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        
        // Ejecutar la consulta
        $stmt->execute();

        // Verificar si se encontró un registro
        if ($stmt->rowCount() > 0) {
            // Obtener la fila (primer resultado)
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar la contraseña
            if (password_verify($contrasena, $row['contrasena'])) {
                // Iniciar sesión o redirigir a la página principal según corresponda
                echo "Inicio de sesión exitoso como " . ucfirst($role);
                // Aquí podrías iniciar sesión o establecer alguna sesión de usuario
                // y redirigir a la página principal
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "Correo no encontrado.";
        }
    } catch(PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
}
?>
