<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Librería Online</title>
  <link rel="stylesheet" href="CSS/styles.css">
  <link rel="stylesheet" href="script.js">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">Librería Online</a>
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

<div class="container mt-4">
  <h1>Bienvenido a la Librería Online</h1>
  <p>
    Aquí puedes encontrar una amplia selección de libros y autores. También puedes revisar nuestras ventas recientes.
  </p>
</div>


<div class="container" id="libros">
  <h2>Listado de Libros</h2>
  <?php

  $dsn = 'mysql:host=localhost;dbname=libreria;charset=utf8mb4';
  $usuario = 'root';
  $contraseña = '';

  try {
    $conexion = new PDO($dsn, $usuario, $contraseña);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $consulta = "SELECT titulos.id_titulo, titulo, GROUP_CONCAT(CONCAT(apellido, ' ', nombre) SEPARATOR ', ') AS autores FROM titulos 
    INNER JOIN titulo_autor ON titulos.id_titulo = titulo_autor.id_titulo 
    INNER JOIN autores ON titulo_autor.id_autor = autores.id_autor
    GROUP BY titulos.id_titulo";
    
    $resultado = $conexion->query($consulta);
    

    echo '<table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Título</th>
              <th>Autores</th>
            </tr>
          </thead>
          <tbody>';
    foreach ($resultado as $fila) {
      echo '<tr>
            <td>' . $fila['id_titulo'] . '</td>
            <td>' . $fila['titulo'] . '</td>
            <td>' . $fila['autores'] . '</td>
          </tr>';
    }
    echo '</tbody></table>';

  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  ?>
</div>

<div class="container mt-4">
  <h2>Contacto</h2>
  <form id="contacto-formulario" method="POST">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre" required>
    </div>
    <div class="mb-3">
      <label for="correo" class="form-label">Correo electrónico</label>
      <input type="email" class="form-control" id="correo" name="correo" required>
    </div>
    <div class="mb-3">
      <label for="asunto" class="form-label">Asunto</label>
      <input type="text" class="form-control" id="asunto" name="asunto" required>
    </div>
    <div class="mb-3">
      <label for="comentario" class="form-label">Comentario</label>
      <textarea class="form-control" id="comentario" name="comentario" rows="4" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary" id="enviar-btn">Enviar</button>
  </form>
</div>
<script>
  document.getElementById("contacto-formulario").addEventListener("submit", function(event) {
    event.preventDefault();

    var form = event.target;
    var formData = new FormData(form);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "procesar_formulario.php", true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        console.log(xhr.responseText);
        if (xhr.status === 200) {
          alert("¡El formulario fue enviado con éxito!");
          form.reset();
        } else {
          alert("Error al enviar el formulario. Por favor, inténtalo de nuevo más tarde.");
        }
      }
    };
    xhr.send(formData);
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
