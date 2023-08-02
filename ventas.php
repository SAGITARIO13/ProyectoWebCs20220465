<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Librería Online - Ventas</title>
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

<?php

$dsn = 'mysql:host=localhost;dbname=libreria;charset=utf8mb4';
$usuario = 'root';
$contraseña = '';

try {
  $conexion = new PDO($dsn, $usuario, $contraseña);
  $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


  $consultaVentas = "SELECT v.id_tienda, v.num_orden, v.fecha, d.id_titulo, t.titulo, ti.nombre_tienda
                     FROM ventas v
                     INNER JOIN detalle_venta d ON v.id_tienda = d.id_tienda AND v.num_orden = d.num_orden
                     INNER JOIN titulos t ON d.id_titulo = t.id_titulo
                     INNER JOIN tiendas ti ON v.id_tienda = ti.id_tienda";

  $resultadoVentas = $conexion->query($consultaVentas);

} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>

<?php
$consultaDisponibles = "SELECT t.id_titulo, t.titulo, t.tipo, t.id_pub, t.precio, t.avance, t.total_ventas, t.notas, t.fecha_pub, t.contrato, 
                              IFNULL(dv.cantidad_disponible, 0) AS cantidad_disponible
                       FROM titulos t
                       LEFT JOIN (SELECT id_titulo, SUM(cantidad) AS cantidad_disponible
                                  FROM detalle_venta
                                  GROUP BY id_titulo) dv ON t.id_titulo = dv.id_titulo
                       WHERE t.total_ventas IS NULL OR t.total_ventas > IFNULL(dv.cantidad_disponible, 0)";

$resultadoDisponibles = $conexion->query($consultaDisponibles);
?>

<div class="container mt-4" id="ventas">
  <h1>Listado de Ventas de Libros</h1>
  <table class="table">
    <thead>
      <tr>
        <th>ID Tienda</th>
        <th>Nombre de la Tienda</th>
        <th>Número de Orden</th>
        <th>Fecha</th>
        <th>Ver Detalle</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($resultadoVentas && $resultadoVentas->rowCount() > 0) : ?>
        <?php
        $numOrdenAnterior = null;
        foreach ($resultadoVentas as $venta) : 
          if ($venta['num_orden'] !== $numOrdenAnterior) :

            $numOrdenAnterior = $venta['num_orden'];
        ?>
          <tr>
            <td><?php echo $venta['id_tienda']; ?></td>
            <td><?php echo $venta['nombre_tienda']; ?></td>
            <td><?php echo $venta['num_orden']; ?></td>
            <td><?php echo $venta['fecha']; ?></td>
            <td><a href="detalle_ventas.php?id_venta=<?php echo $venta['num_orden']; ?>" class="btn btn-primary btn-ver-detalle">Ver Detalle</a></td>
          </tr>
        <?php endif; ?>
        <?php endforeach; ?>
      <?php else : ?>
        <tr>
          <td colspan="5">No hay ventas de libros registradas</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>


<div class="container mt-4" id="librosDisponibles">
  <h1>Listado de Libros Disponibles</h1>
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Tipo</th>
        <th>ID del Publicador</th>
        <th>Precio</th>
        <th>Avance</th>
        <th>Total de Ventas</th>
        <th>Notas</th>
        <th>Fecha de Publicación</th>
        <th>Contrato</th>
        <th>Cantidad Disponible</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($resultadoDisponibles && $resultadoDisponibles->rowCount() > 0) : ?>
        <?php foreach ($resultadoDisponibles as $libro) : ?>
          <tr>
            <td><?php echo $libro['id_titulo']; ?></td>
            <td><?php echo $libro['titulo']; ?></td>
            <td><?php echo $libro['tipo']; ?></td>
            <td><?php echo $libro['id_pub']; ?></td>
            <td><?php echo $libro['precio']; ?></td>
            <td><?php echo $libro['avance']; ?></td>
            <td><?php echo $libro['total_ventas']; ?></td>
            <td><?php echo $libro['notas']; ?></td>
            <td><?php echo $libro['fecha_pub']; ?></td>
            <td><?php echo $libro['contrato']; ?></td>
            <td><?php echo $libro['cantidad_disponible']; ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else : ?>
        <tr>
          <td colspan="11">No hay libros disponibles</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
