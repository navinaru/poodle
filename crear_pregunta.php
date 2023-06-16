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

// Retrieve the list of categorias
$sql = "SELECT id, nombreCategoria FROM categoria";
$result_categorias = $conn->query($sql);

// Array to store the categorias
$categorias = array();
while ($row = $result_categorias->fetch_assoc()) {
    $categorias[$row['id']] = $row['nombreCategoria'];
}

// Check if the form is submitted for creating a pregunta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["create_pregunta"])) {
        // Retrieve the pregunta data from the form
        $enunciado = $_POST["enunciado"];
        $respuestaA = $_POST["respuestaA"];
        $respuestaB = $_POST["respuestaB"];
        $respuestaC = $_POST["respuestaC"];
        $respuestaD = $_POST["respuestaD"];
        $categoria = $_POST["categoria"];
        $correcto = $_POST["correcto"];

        // Validate the input
        if (empty($enunciado) || empty($respuestaA) || empty($respuestaB) || empty($respuestaC) || empty($respuestaD)) {
            echo "All fields are required.";
        } elseif ($correcto !== $respuestaA && $correcto !== $respuestaB && $correcto !== $respuestaC && $correcto !== $respuestaD) {
            echo "Una de las opciones debe de coincidir con la pregunta correcta";
        } else {
            // Insert the new pregunta into the database
            $sql = "INSERT INTO pregunta (enunciado, respuestaA, respuestaB, respuestaC, respuestaD, categoria, correcto) VALUES ('$enunciado', '$respuestaA', '$respuestaB', '$respuestaC', '$respuestaD', '$categoria', '$correcto')";
            if ($conn->query($sql) === TRUE) {
                echo "Pregunta created successfully.";
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
    <title>Create Pregunta</title>
</head>
<body>
    <h2>Create Pregunta</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="enunciado">Enunciado:</label>
        <textarea name="enunciado" required></textarea>
        <br>
        <label for="respuestaA">Respuesta A:</label>
        <input type="text" name="respuestaA" required>
        <br>
        <label for="respuestaB">Respuesta B:</label>
        <input type="text" name="respuestaB" required>
        <br>
        <label for="respuestaC">Respuesta C:</label>
        <input type="text" name="respuestaC" required>
        <br>
        <label for="respuestaD">Respuesta D:</label>
        <input type="text" name="respuestaD" required>
        <br>
        <label for="categoria">Categoria:</label>
        <select name="categoria">
            <?php foreach ($categorias as $categoria_id => $nombreCategoria) { ?>
                <option value="<?php echo $categoria_id; ?>"><?php echo $nombreCategoria; ?></option>
            <?php } ?>
        </select>
        <br>
        <label for="correcto">Correct Answer:</label>
        <input type="text" name="correcto" required>
        <br>
        <input type="submit" name="create_pregunta" value="Create Pregunta">
    </form>

    </p>
  </div>


</body>
</html>

