<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Librería Online</title>
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
          <a class="nav-link" href="libros.php#libros">Libros</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="autores.php#autores">Autores</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ventas.php#ventas">Ventas</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


<div class="container mt-4" id="libros">
  <h1>Listado de Libros</h1>
  <?php

  $dsn = 'mysql:host=localhost;dbname=libreria;charset=utf8mb4';
  $usuario = 'root';
  $contraseña = '';

  try {
    $conexion = new PDO($dsn, $usuario, $contraseña);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $consulta = "SELECT 
                    titulos.id_titulo, 
                    titulo, 
                    GROUP_CONCAT(DISTINCT CONCAT(apellido, ' ', nombre) SEPARATOR ', ') AS autores, 
                    nombre_pub, 
                    GROUP_CONCAT(DISTINCT nombre_tienda SEPARATOR ', ') AS tiendas, 
                    derechos.derechos AS derechos_libro, 
                    biografia
                FROM titulos 
                LEFT JOIN titulo_autor ON titulos.id_titulo = titulo_autor.id_titulo 
                LEFT JOIN autores ON titulo_autor.id_autor = autores.id_autor
                LEFT JOIN publicadores ON titulos.id_pub = publicadores.id_pub
                LEFT JOIN tiendas ON tiendas.terminos = titulos.id_titulo
                LEFT JOIN derechos ON titulos.id_titulo = derechos.id_titulo
                LEFT JOIN biografias ON autores.id_autor = biografias.id_autor
                GROUP BY titulos.id_titulo";
    
    $resultado = $conexion->query($consulta);
    

    echo '<table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Título</th>
              <th>Autores</th>
              <th>Publicador</th>
              <th>Tiendas</th>
              <th>Derechos</th>
              <th>Biografía</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>';
    foreach ($resultado as $fila) {
      echo '<tr>
            <td>' . $fila['id_titulo'] . '</td>
            <td>' . $fila['titulo'] . '</td>
            <td>' . $fila['autores'] . '</td>
            <td>' . $fila['nombre_pub'] . '</td>
            <td>' . $fila['tiendas'] . '</td>
            <td>' . $fila['derechos_libro'] . '</td>
            <td>' . $fila['biografia'] . '</td>
            <td><a href="detalle_libro.php?id_titulo=' . $fila['id_titulo'] . '" class="btn btn-primary btn-ver-detalle">Ver Detalle</a></td>
          </tr>';
    }
    echo '</tbody></table>';

  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
