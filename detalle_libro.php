<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalle del Libro</title>
  <link rel="stylesheet" href="CSS/detalle_libro.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>


<div class="container">
  <?php 

  if (isset($_GET['id_titulo'])) {
    $id_titulo = $_GET['id_titulo'];


    $dsn = 'mysql:host=localhost;dbname=libreria;charset=utf8mb4';
    $usuario = 'root';
    $contraseña = '';

    try {
      $conexion = new PDO($dsn, $usuario, $contraseña);
      $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      echo 'Error de conexión: ' . $e->getMessage();
      exit;
    }

    $consulta = 'SELECT t.id_titulo, t.titulo, CONCAT(a.nombre, " ", a.apellido) AS nombre_autor, b.biografia, p.nombre_pub
                 FROM titulos t
                 JOIN titulo_autor ta ON t.id_titulo = ta.id_titulo
                 JOIN autores a ON ta.id_autor = a.id_autor
                 LEFT JOIN biografias b ON a.id_autor = b.id_autor
                 JOIN publicadores p ON t.id_pub = p.id_pub
                 WHERE t.id_titulo = :id_titulo';

    try {
      $stmt = $conexion->prepare($consulta);
      $stmt->bindParam(':id_titulo', $id_titulo, PDO::PARAM_STR);
      $stmt->execute();
      $detallesLibro = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo 'Error en la consulta: ' . $e->getMessage();
      exit;
    }


    if ($detallesLibro) {
      echo '<h1>Detalles del libro</h1>';
      echo '<p><strong>ID:</strong> ' . $detallesLibro['id_titulo'] . '</p>';
      echo '<p><strong>Título:</strong> ' . $detallesLibro['titulo'] . '</p>';
      echo '<p><strong>Autor:</strong> ' . $detallesLibro['nombre_autor'] . '</p>';
      echo '<p><strong>Biografía:</strong> ' . $detallesLibro['biografia'] . '</p>';
      echo '<p><strong>Publicadora:</strong> ' . $detallesLibro['nombre_pub'] . '</p>';
    } else {
  
      echo '<p>Error: No se encontró el libro.</p>';
    }
  } else {

    echo '<p>Error: No se encontró el ID del libro.</p>';
  }
  ?>
  <a href="libros.php" class="btn-volver">volver</a>
</div>

</body>
</html>
