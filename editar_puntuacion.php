<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POODLE</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Top Navigation Bar -->
 
  <?php require './navbar.php'; ?>

  <!-- Body Content -->
  <div class="content">
    <p>
    <?php
    // Database connection settings
    $conn = mysqli_connect("localhost", "root", "", "proyecto");

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }


  // Retrieve the list of categorias
  $sql = "SELECT id, nombrecategoria FROM categoria";
  $result_categorias = $conn->query($sql);
  
  // Array to store the categorias
  $categorias = array();
  while ($row = $result_categorias->fetch_assoc()) {
      $categorias[$row['id']] = $row['nombrecategoria'];
  }
  
  // Check if the form is submitted for updating or deleting a pregunta entry
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST["update_pregunta"])) {
          // Retrieve the pregunta data from the form
          $id = $_POST["pregunta_id"];
          $enunciado = $_POST["enunciado"];
          $respuestaA = $_POST["respuestaA"];
          $respuestaB = $_POST["respuestaB"];
          $respuestaC = $_POST["respuestaC"];
          $respuestaD = $_POST["respuestaD"];
          $categoria = $_POST["categoria"];
          $correcto = $_POST["correcto"];
  
          // Check if the correcto value matches any of the respuestas
          if ($correcto == $respuestaA || $correcto == $respuestaB || $correcto == $respuestaC || $correcto == $respuestaD) {
              // Update the pregunta entry in the database
              $sql = "UPDATE pregunta SET enunciado='$enunciado', respuestaA='$respuestaA', respuestaB='$respuestaB', respuestaC='$respuestaC', respuestaD='$respuestaD', categoria='$categoria', correcto='$correcto' WHERE id='$id'";
              if ($conn->query($sql) === TRUE) {
                  echo "Pregunta entry updated successfully.";
              } else {
                  echo "Error: " . $sql . "<br>" . $conn->error;
              }
          } else {
              echo "Error: Correcto value must match one of the respuestas.";
          }
      } elseif (isset($_POST["delete_pregunta"])) {
          // Retrieve the pregunta ID from the form
          $id = $_POST["pregunta_id"];
  
          // Delete the pregunta entry from the database
          $sql = "DELETE FROM pregunta WHERE id='$id'";
          if ($conn->query($sql) === TRUE) {
              echo "Pregunta entry deleted successfully.";
          } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
          }
      }
  }
  
  // Retrieve the preguntas from the database
  $sql = "SELECT * FROM pregunta";
  $result_preguntas = $conn->query($sql);
  
  // Close the database connection
  $conn->close();
  ?>
  
  <!DOCTYPE html>
  <html>
  <head>
      <title>Manage Preguntas</title>
  </head>
  <body>
      <h2>Manage Preguntas</h2>
      <table>
          <tr>
              <th>ID</th>
              <th>Enunciado</th>
              <th>Respuesta A</th>
              <th>Respuesta B</th>
              <th>Respuesta C</th>
              <th>Respuesta D</th>
              <th>Categoria</th>
              <th>Correcto</th>
              <th>Action</th>
          </tr>
          <?php while ($row = $result_preguntas->fetch_assoc()) { ?>
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
                          <input type="submit" name="update_pregunta" value="Update">
                          <input type="submit" name="delete_pregunta" value="Delete" onclick="return confirm('Are you sure you want to delete this pregunta?');">
                      </td>
                  </form>
              </tr>
          <?php } ?>
      </table>

    </p>
  </div>


</body>
</html>

