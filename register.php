<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dinoservicios";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];
    $direccion = $_POST['direccion'];

    try {
        // Crear una conexión a la base de datos usando PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Configurar el modo de error de PDO para que lance excepciones
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Hash de la contraseña (recomendado)
        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

        // Preparar la consulta SQL para insertar en la tabla clientes
        $sql = "INSERT INTO clientes (correo, nombre_usuario, contrasena, direccion)
                VALUES (:correo, :nombre_usuario, :contrasena, :direccion)";
        
        // Preparar la declaración
        $stmt = $conn->prepare($sql);
        
        // Bind de parámetros
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
        $stmt->bindParam(':contrasena', $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        
        // Ejecutar la consulta
        $stmt->execute();

        echo "Registro exitoso. Ahora puedes <a href='./iniciar.html'>iniciar sesión</a>.";
    } catch(PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
}
?>
