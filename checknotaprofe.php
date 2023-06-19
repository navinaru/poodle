<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POODLE</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="prompt-box">
    <!-- Top Navigation Bar -->
   
    <?php require './navbar.php'; ?>

    <!-- Body Content -->
    <div class="content">
      <p>
      <?php
  // Conectar a la base de datos
  $conn = mysqli_connect("localhost", "root", "", "proyecto");

    // Verificar conexión
    if (mysqli_connect_errno()) {
        die("Error de conexión: " . mysqli_connect_error());
    }

  // Función para limpiar la entrada de datos
  function sanitizeInput($input)
  {
      return htmlspecialchars(stripslashes(trim($input)));
  }

  // Actualizar el campo nota
  if (isset($_POST['update'])) {
      $nota = sanitizeInput($_POST['nota']);
      $id = sanitizeInput($_POST['id']);

      // Validar que la nota sea un número
      if (!is_numeric($nota)) {
          echo "La nota debe ser un número.";
      } else {
          $sql = "UPDATE examenes_usuarios SET nota = $nota WHERE id = $id";
          if (mysqli_query($conn, $sql)) {
              header("Location: " . $_SERVER['PHP_SELF']);
              exit();
          } else {
              echo "Error al actualizar la nota: " . mysqli_error($conn);
          }
      }
  }

  // Obtener y mostrar los datos
  $sql = "SELECT examenes_usuarios.id, examenes.titulo, examenes_usuarios.usuario, examenes_usuarios.nota 
          FROM examenes_usuarios
          INNER JOIN examenes ON examenes_usuarios.examen = examenes.id";
  $result = mysqli_query($conn, $sql);
  ?>

  <!DOCTYPE html>
  <html>
  <head>
      <title>Editar Exámenes Usuarios</title>
  </head>
  <body>
      <h1>Editar Exámenes Usuarios</h1>
      <table>
          <tr>
              <th>ID</th>
              <th>Examen</th>
              <th>Usuario</th>
              <th>Nota</th>
              <th>Actualizar</th>
          </tr>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
              <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <td><?php echo $row['id']; ?></td>
                  <td><?php echo $row['titulo']; ?></td>
                  <td><?php echo $row['usuario']; ?></td>
                  <td><input type="text" name="nota" value="<?php echo $row['nota']; ?>"></td>
                  <td>
                      <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                      <input type="submit" name="update" value="Actualizar">
                  </td>
              </form>
          </tr>
          <?php endwhile; ?>
      </table>
  </body>
  </html>

  <?php
  // Cerrar la conexión a la base de datos
  mysqli_close($conn);
  ?>


      </p>
    </div>
  </div>
</body>
</html>

