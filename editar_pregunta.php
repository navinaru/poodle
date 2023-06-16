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

// Retrieve the list of examenes
$sql = "SELECT id, titulo FROM examenes";
$result_examenes = $conn->query($sql);

// Array to store the examenes
$examenes = array();
while ($row = $result_examenes->fetch_assoc()) {
    $examenes[$row['id']] = $row['titulo'];
}

// Check if the examen is selected
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["examen_id"])) {
    // Retrieve the selected examen ID from the form
    $examen_id = $_POST["examen_id"];

    // Retrieve the list of preguntas related to the selected examen
    $sql = "SELECT pregunta.id, pregunta.enunciado, preguntas_examenes.puntuacion FROM pregunta JOIN preguntas_examenes ON pregunta.id = preguntas_examenes.pregunta WHERE preguntas_examenes.examen = '$examen_id'";
    $result_preguntas = $conn->query($sql);

    // Array to store the preguntas
    $preguntas = array();
    while ($row = $result_preguntas->fetch_assoc()) {
        $preguntas[$row['id']] = $row;
    }
}

// Check if the form is submitted for updating or deleting a pregunta_examenes entry
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["update_pregunta_examenes"])) {
        // Retrieve the pregunta_examenes data from the form
        $examen_id = $_POST["examen_id"];
        $pregunta_id = $_POST["pregunta_id"];
        $puntuacion = $_POST["puntuacion"];

        // Update the pregunta_examenes entry in the database
        $sql = "UPDATE preguntas_examenes SET puntuacion='$puntuacion' WHERE examen='$examen_id' AND pregunta='$pregunta_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Pregunta_examenes entry updated successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST["delete_pregunta_examenes"])) {
        // Retrieve the pregunta_examenes data from the form
        $examen_id = $_POST["examen_id"];
        $pregunta_id = $_POST["pregunta_id"];

        // Delete the pregunta_examenes entry from the database
        $sql = "DELETE FROM preguntas_examenes WHERE examen='$examen_id' AND pregunta='$pregunta_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Pregunta_examenes entry deleted successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Pregunta_examenes</title>
</head>
<body>
    <h2>Manage Pregunta_examenes</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="examen_id">Select Examen:</label>
        <select name="examen_id" id="examen_id">
            <?php foreach ($examenes as $examen_id => $titulo) { ?>
                <option value="<?php echo $examen_id; ?>"><?php echo $titulo; ?></option>
            <?php } ?>
        </select>
        <input type="submit" value="Select">
    </form>
    <?php if (isset($preguntas)) { ?>
        <table>
            <tr>
                <th>Examen</th>
                <th>Pregunta</th>
                <th>Puntuacion</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php foreach ($preguntas as $pregunta_id => $pregunta) { ?>
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <tr>
                        <td>
                            <input type="hidden" name="examen_id" value="<?php echo $examen_id; ?>">
                            <?php echo $examenes[$examen_id]; ?>
                        </td>
                        <td>
                            <input type="hidden" name="pregunta_id" value="<?php echo $pregunta_id; ?>">
                            <?php echo $pregunta['enunciado']; ?>
                        </td>
                        <td>
                            <input type="text" name="puntuacion" value="<?php echo $pregunta['puntuacion']; ?>" pattern="[0-9]+" title="Please enter a number.">
                        </td>
                        <td>
                            <input type="submit" name="update_pregunta_examenes" value="Update">
                        </td>
                        <td>
                            <input type="submit" name="delete_pregunta_examenes" value="Delete" onclick="return confirm('Are you sure you want to delete this pregunta?');">
                        </td>
                    </tr>
                </form>
            <?php } ?>
        </table>
    <?php } ?>

    </p>
  </div>


</body>
</html>

