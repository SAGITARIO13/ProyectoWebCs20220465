<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $nombre = $_POST['nombre'];
  $correo = $_POST['correo'];
  $asunto = $_POST['asunto'];
  $comentario = $_POST['comentario'];

  $dsn = 'mysql:host=localhost;dbname=libreria;charset=utf8mb4';
  $usuario = 'root';
  $contraseña = '';

  try {
    $conexion = new PDO($dsn, $usuario, $contraseña);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $consulta = "INSERT INTO contacto (nombre, correo, asunto, comentario) VALUES (:nombre, :correo, :asunto, :comentario)";

    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
    $stmt->bindParam(':asunto', $asunto, PDO::PARAM_STR);
    $stmt->bindParam(':comentario', $comentario, PDO::PARAM_STR);
    $stmt->execute();

    echo "¡Gracias por tu mensaje! Tu consulta ha sido enviada correctamente.";

  } catch (PDOException $e) {
  
    echo "Error al procesar el formulario. Por favor, inténtalo de nuevo más tarde.";
  }
} else {

  header("HTTP/1.1 400 Bad Request");
  echo "Error: Petición incorrecta";
}
?>
