<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POODLE</title>
  <link rel="stylesheet" href="style.css#2">
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

// Retrieve the list of grupos
$sql = "SELECT id, nombreGrupo FROM grupos";
$result_grupos = $conn->query($sql);

// Array to store the grupos
$grupos = array();
while ($row = $result_grupos->fetch_assoc()) {
    $grupos[$row['id']] = $row['nombreGrupo'];
}

// Retrieve the list of categorias
$sql = "SELECT id, nombreCategoria FROM categoria";
$result_categorias = $conn->query($sql);

// Array to store the categorias
$categorias = array();
while ($row = $result_categorias->fetch_assoc()) {
    $categorias[$row['id']] = $row['nombreCategoria'];
}

// Check if the form is submitted for creating an examen
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["create_examen"])) {
        // Retrieve the examen data from the form
        $titulo = $_POST["titulo"];
        $grupo = $_POST["grupo"];
        $fk_categoria = $_POST["fk_categoria"];
        $puntuacionTotal = $_POST["puntuacionTotal"];
        $borrado = isset($_POST["borrado"]) ? 1 : 0;
        $creador = $_SESSION["correo"];

        // Validate the input
        if (empty($titulo)) {
            echo "Title is required.";
        } else {
            // Insert the new examen into the database
            $sql = "INSERT INTO examenes (titulo, grupo, fk_categoria, puntuacionTotal, borrado, creador) VALUES ('$titulo', '$grupo', '$fk_categoria', '$puntuacionTotal', '$borrado', '$creador')";
            if ($conn->query($sql) === TRUE) {
                echo "Examen created successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Exam</title>
</head>
<body>
    <h2>Create Exam</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="titulo">Title:</label>
        <input type="text" name="titulo" required>
        <br>
        <label for="grupo">Grupo:</label>
        <select name="grupo">
            <?php foreach ($grupos as $grupo_id => $nombreGrupo) { ?>
                <option value="<?php echo $grupo_id; ?>"><?php echo $nombreGrupo; ?></option>
            <?php } ?>
        </select>
        <br>
        <label for="fk_categoria">Categoria:</label>
        <select name="fk_categoria">
            <?php foreach ($categorias as $categoria_id => $nombreCategoria) { ?>
                <option value="<?php echo $categoria_id; ?>"><?php echo $nombreCategoria; ?></option>
            <?php } ?>
        </select>
        <br>
        <label for="puntuacionTotal">Total Score:</label>
        <input type="text" name="puntuacionTotal">
        <br>
        <label for="borrado">Deleted:</label>
        <input type="checkbox" name="borrado" value="1">
        <br>
        <input type="hidden" name="creador" value="<?php echo $_SESSION['correo']; ?>">
        <input type="submit" name="create_examen" value="Create Exam">
    </form>
</body>
</html>

    </p>
  </div>


</body>
</html>