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

// Retrieve the list of examenes
$sql = "SELECT id, titulo FROM examenes";
$result_examenes = $conn->query($sql);

// Array to store the examenes
$examenes = array();
while ($row = $result_examenes->fetch_assoc()) {
    $examenes[$row['id']] = $row['titulo'];
}

// Retrieve the list of preguntas
$sql = "SELECT id, enunciado FROM pregunta";
$result_preguntas = $conn->query($sql);

// Array to store the preguntas
$preguntas = array();
while ($row = $result_preguntas->fetch_assoc()) {
    $preguntas[$row['id']] = $row['enunciado'];
}

// Check if the form is submitted for creating a preguntas_examenes entry
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["create_preguntas_examenes"])) {
        // Retrieve the preguntas_examenes data from the form
        $examen = $_POST["examen"];
        $pregunta = $_POST["pregunta"];
        $puntuacion = $_POST["puntuacion"];

        // Validate the input
        if (!is_numeric($puntuacion)) {
            echo "Puntuacion must be a number.";
        } else {
            // Insert the new preguntas_examenes entry into the database
            $sql = "INSERT INTO preguntas_examenes (examen, pregunta, puntuacion) VALUES ('$examen', '$pregunta', '$puntuacion')";
            if ($conn->query($sql) === TRUE) {
                echo "Preguntas_examenes entry created successfully.";
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
    <title>Create Preguntas_Examenes</title>
</head>
<body>
    <h2>Create Preguntas_Examenes</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="examen">Examen:</label>
        <select name="examen">
            <?php foreach ($examenes as $examen_id => $titulo) { ?>
                <option value="<?php echo $examen_id; ?>"><?php echo $titulo; ?></option>
            <?php } ?>
        </select>
        <br>
        <label for="pregunta">Pregunta:</label>
        <select name="pregunta">
            <?php foreach ($preguntas as $pregunta_id => $enunciado) { ?>
                <option value="<?php echo $pregunta_id; ?>"><?php echo $enunciado; ?></option>
            <?php } ?>
        </select>
        <br>
        <label for="puntuacion">Puntuacion:</label>
        <input type="text" name="puntuacion" required>
        <br>
        <input type="submit" name="create_preguntas_examenes" value="Create Preguntas_Examenes">
    </form>
</body>
</html>

    </p>
  </div>


</body>
</html>

