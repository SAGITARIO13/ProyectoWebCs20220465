<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Librería Online - Autores</title>
  <link rel="stylesheet" href="CSS/styles.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">Librería Online</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="libros.php">Libros</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="autores.php">Autores</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ventas.php">Ventas</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
  <h1>Autores</h1>
  <table class="table">
    <thead>
      <tr>
        <th>ID Autor</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Teléfono</th>
        <th>Dirección</th>
        <th>Ciudad</th>
        <th>Estado</th>
        <th>País</th>
        <th>Código Postal</th>
      </tr>
    </thead>
    <tbody>
      <?php
   
        $dsn = 'mysql:host=localhost;dbname=libreria;charset=utf8mb4';
        $usuario = 'root';
        $contraseña = '';

        try {
          $conn = new PDO($dsn, $usuario, $contraseña);
     
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   
          $sql = "SELECT * FROM autores";
          $result = $conn->query($sql);

      
          if ($result->rowCount() > 0) {
            foreach ($result as $autor) {
              echo '<tr>';
              echo '<td>' . $autor['id_autor'] . '</td>';
              echo '<td>' . $autor['nombre'] . '</td>';
              echo '<td>' . $autor['apellido'] . '</td>';
              echo '<td>' . $autor['telefono'] . '</td>';
              echo '<td>' . $autor['direccion'] . '</td>';
              echo '<td>' . $autor['ciudad'] . '</td>';
              echo '<td>' . $autor['estado'] . '</td>';
              echo '<td>' . $autor['pais'] . '</td>';
              echo '<td>' . $autor['cod_postal'] . '</td>';
              echo '</tr>';
            }
          } else {
            echo '<tr><td colspan="9">No se encontraron autores en la base de datos.</td></tr>';
          }
        } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
        }

        $conn = null;
      ?>
    </tbody>
  </table>
</div>

</body>
</html>
