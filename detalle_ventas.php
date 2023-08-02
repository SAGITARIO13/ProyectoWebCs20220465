<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalle de Venta - Librería Online</title>
  <link rel="stylesheet" href="CSS/detalle_venta.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container">
  <?php 

  if (isset($_GET['id_venta'])) {
    $idVenta = $_GET['id_venta'];

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

    $consulta = 'SELECT v.id_tienda, v.num_orden, v.fecha, d.id_titulo, t.titulo, ti.nombre_tienda, t.precio, d.cantidad, d.descuento
                 FROM ventas v
                 INNER JOIN detalle_venta d ON v.id_tienda = d.id_tienda AND v.num_orden = d.num_orden
                 INNER JOIN titulos t ON d.id_titulo = t.id_titulo
                 INNER JOIN tiendas ti ON v.id_tienda = ti.id_tienda
                 WHERE v.num_orden = :id_venta';

    try {
      $stmt = $conexion->prepare($consulta);
      $stmt->bindParam(':id_venta', $idVenta, PDO::PARAM_STR);
      $stmt->execute();
      $detallesVenta = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo 'Error en la consulta: ' . $e->getMessage();
      exit;
    }


    if ($detallesVenta) {
      echo '<h1>Detalles de la Venta</h1>';
      echo '<table class="table">';
      echo '<thead><tr>
              <th>ID Tienda</th>
              <th>Nombre de la Tienda</th>
              <th>Número de Orden</th>
              <th>Fecha</th>
              <th>ID del Libro</th>
              <th>Título del Libro</th>
              <th>Precio del Título</th>
              <th>Cantidad Vendida</th>
              <th>Descuento (%)</th>
            </tr></thead>';
      echo '<tbody>';
      foreach ($detallesVenta as $venta) {
        echo '<tr>';
        echo '<td>' . $venta['id_tienda'] . '</td>';
        echo '<td>' . $venta['nombre_tienda'] . '</td>';
        echo '<td>' . $venta['num_orden'] . '</td>';
        echo '<td>' . $venta['fecha'] . '</td>';
        echo '<td>' . $venta['id_titulo'] . '</td>';
        echo '<td>' . $venta['titulo'] . '</td>';
        echo '<td>' . $venta['precio'] . '</td>';
        echo '<td>' . $venta['cantidad'] . '</td>';
        echo '<td>' . $venta['descuento'] . '</td>';
        echo '</tr>';
      }
      echo '</tbody>';
      echo '</table>';
    } else {
      echo '<p>Error: No se encontró la venta.</p>';
    }
  } else {
    echo '<p>Error: No se encontró el ID de la venta.</p>';
  }
  ?>
  <a href="ventas.php" class="btn-volver">Volver</a>
</div>

</body>
</html>
