<?php
$servername = "localhost";
$username = "root"; // El usuario por defecto de MySQL en XAMPP es "root"
$password = ""; // La contraseña por defecto de MySQL en XAMPP es vacía
$dbname = "dinoservicios";

try {
    // Crear una conexión a la base de datos usando PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Configurar el modo de error de PDO para que lance excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a la base de datos";
}
catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
