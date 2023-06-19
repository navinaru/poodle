<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POODLE</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Barra de navegación superior -->
 
  <?php require './navbar.php'; ?>

  <!-- Contenido del cuerpo -->
  <div class="content">
    <p>
    <?php
    // Configuración de la conexión a la base de datos
    $conn = mysqli_connect("localhost", "root", "", "proyecto");

    // Comprobar la conexión
    if (mysqli_connect_errno()) {
        die("La conexión ha fallado: " . mysqli_connect_error());
    }

    // Obtener la lista de categorías
    $sql = "SELECT id, nombrecategoria FROM categoria";
    $result_categorias = mysqli_query($conn, $sql);
  
    // Array para almacenar las categorías
    $categorias = array();
    while ($row = mysqli_fetch_assoc($result_categorias)) {
        $categorias[$row['id']] = $row['nombrecategoria'];
    }
  
    // Comprobar si se ha enviado el formulario para actualizar o eliminar una entrada de pregunta
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["update_pregunta"])) {
            // Obtener los datos de la pregunta del formulario
            $id = $_POST["pregunta_id"];
            $enunciado = $_POST["enunciado"];
            $respuestaA = $_POST["respuestaA"];
            $respuestaB = $_POST["respuestaB"];
            $respuestaC = $_POST["respuestaC"];
            $respuestaD = $_POST["respuestaD"];
            $categoria = $_POST["categoria"];
            $correcto = $_POST["correcto"];
  
            // Comprobar si el valor correcto coincide con alguna de las respuestas
            if ($correcto == $respuestaA || $correcto == $respuestaB || $correcto == $respuestaC || $correcto == $respuestaD) {
                // Actualizar la entrada de pregunta en la base de datos
                $sql = "UPDATE pregunta SET enunciado='$enunciado', respuestaA='$respuestaA', respuestaB='$respuestaB', respuestaC='$respuestaC', respuestaD='$respuestaD', categoria='$categoria', correcto='$correcto' WHERE id='$id'";
                if (mysqli_query($conn, $sql)) {
                    echo "La entrada de pregunta se ha actualizado correctamente.";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            } else {
                echo "Error: El valor correcto debe coincidir con una de las respuestas.";
            }
        } elseif (isset($_POST["delete_pregunta"])) {
            // Obtener el ID de la pregunta del formulario
            $id = $_POST["pregunta_id"];
  
            // Eliminar la entrada de pregunta de la base de datos
            $sql = "DELETE FROM pregunta WHERE id='$id'";
            if (mysqli_query($conn, $sql)) {
                echo "La entrada de pregunta se ha eliminado correctamente.";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }
  
    // Obtener las preguntas de la base de datos
    $sql = "SELECT * FROM pregunta";
    $result_preguntas = mysqli_query($conn, $sql);
  
    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
    ?>
  
    <div style="border: 1px solid black; padding: 10px;">
      <h2>Gestionar Preguntas</h2>
      <table>
          <tr>
              <th>ID</th>
              <th>Enunciado</th>
              <th>Respuesta A</th>
              <th>Respuesta B</th>
              <th>Respuesta C</th>
              <th>Respuesta D</th>
              <th>Categoría</th>
              <th>Correcto</th>
              <th>Acción</th>
          </tr>
          <?php while ($row = mysqli_fetch_assoc($result_preguntas)) { ?>
              <tr>
                  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                      <input type="hidden" name="pregunta_id" value="<?php echo $row['id']; ?>">
                      <td><?php echo $row['id']; ?></td>
                      <td><input type="text" name="enunciado" value="<?php echo $row['enunciado']; ?>"></td>
                      <td><input type="text" name="respuestaA" value="<?php echo $row['respuestaA']; ?>"></td>
                      <td><input type="text" name="respuestaB" value="<?php echo $row['respuestaB']; ?>"></td>
                      <td><input type="text" name="respuestaC" value="<?php echo $row['respuestaC']; ?>"></td>
                      <td><input type="text" name="respuestaD" value="<?php echo $row['respuestaD']; ?>"></td>
                      <td>
                          <select name="categoria">
                              <?php foreach ($categorias as $categoria_id => $nombrecategoria) { ?>
                                  <option value="<?php echo $categoria_id; ?>" <?php if ($categoria_id == $row['categoria']) echo "selected"; ?>><?php echo $nombrecategoria; ?></option>
                              <?php } ?>
                          </select>
                      </td>
                      <td><input type="text" name="correcto" value="<?php echo $row['correcto']; ?>"></td>
                      <td>
                          <input type="submit" name="update_pregunta" value="Actualizar">
                          <input type="submit" name="delete_pregunta" value="Eliminar" onclick="return confirm('¿Estás seguro de que quieres eliminar esta pregunta?');">
                      </td>
                  </form>
              </tr>
          <?php } ?>
      </table>
    </div>

    </p>
  </div>
</body>
</html>
