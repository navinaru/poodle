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
    require "./conn.php";
    $conn = getconn();
// Función para sanitizar la entrada de datos
function sanitize($input) {
    global $conn;
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    $input = mysqli_real_escape_string($conn, $input);
    return $input;
}

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si la acción es editar la puntuación
    if (isset($_POST['edit_score'])) {
        $questionId = sanitize($_POST['question_id']);
        $newScore = sanitize($_POST['score']);

        // Actualizar la puntuación en la tabla preguntas_examenes
        $updateQuery = "UPDATE preguntas_examenes SET puntuacion = $newScore WHERE pregunta = $questionId";
        mysqli_query($conn, $updateQuery);
    }

    // Verificar si la acción es eliminar la puntuación
    if (isset($_POST['delete_score'])) {
        $questionId = sanitize($_POST['question_id']);

        // Eliminar la puntuación de la tabla preguntas_examenes
        $deleteQuery = "DELETE FROM preguntas_examenes WHERE pregunta = $questionId";
        mysqli_query($conn, $deleteQuery);
    }
}

// Consultar todos los exámenes
$examsQuery = "SELECT id, titulo FROM examenes";
$examsResult = mysqli_query($conn, $examsQuery);

// Verificar si existen exámenes
if (mysqli_num_rows($examsResult) > 0) {
    // Mostrar el menú desplegable y el formulario
    echo "<form method='GET' action=''>
        <label for='examen'>Selecciona un Examen:</label>
        <select name='examen' id='examen'>
            <option value=''>-- Selecciona un Examen --</option>";

    while ($examRow = mysqli_fetch_assoc($examsResult)) {
        $examId = $examRow['id'];
        $examTitle = $examRow['titulo'];

        echo "<option value='$examId'>$examTitle</option>";
    }

    echo "</select>
        <button type='submit'>Mostrar Preguntas</button>
    </form>";

    // Verificar si el formulario ha sido enviado
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['examen'])) {
        $examenId = sanitize($_GET['examen']);

        // Verificar si el examen seleccionado es válido
        $examQuery = "SELECT * FROM examenes WHERE id = $examenId";
        $examResult = mysqli_query($conn, $examQuery);

        if (mysqli_num_rows($examResult) > 0) {
            $examRow = mysqli_fetch_assoc($examResult);
            $examTitle = $examRow['titulo'];

            // Consultar las preguntas asociadas al examen
            $questionsQuery = "SELECT p.id, p.enunciado, pe.puntuacion
                FROM pregunta p
                INNER JOIN preguntas_examenes pe ON p.id = pe.pregunta
                WHERE pe.examen = $examenId";
            $questionsResult = mysqli_query($conn, $questionsQuery);

            echo "<h1>Preguntas para el Examen: $examTitle</h1>";

            if (mysqli_num_rows($questionsResult) > 0) {
                // Mostrar las preguntas
                echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Pregunta</th>
                        <th>Puntuación</th>
                        <th>Acciones</th>
                    </tr>";

                while ($questionRow = mysqli_fetch_assoc($questionsResult)) {
                    $questionId = $questionRow['id'];
                    $questionEnunciado = $questionRow['enunciado'];
                    $questionPuntuacion = $questionRow['puntuacion'];

                    echo "<tr>
                        <td>$questionId</td>
                        <td>$questionEnunciado</td>
                        <td>$questionPuntuacion</td>
                        <td>
                            <form method='POST' action=''>
                                <input type='hidden' name='question_id' value='$questionId'>
                                <input type='number' name='score' value='$questionPuntuacion'>
                                <button type='submit' name='edit_score'>Editar Puntuación</button>
                                <button type='submit' name='delete_score'>Eliminar Puntuación</button>
                            </form>
                        </td>
                    </tr>";
                }

                echo "</table>";
            } else {
                echo "No se encontraron preguntas para este examen.";
            }
        } else {
            echo "Examen no encontrado.";
        }
    }
} else {
    echo "No se encontraron exámenes.";
}

mysqli_close($conn);
?>

    </p>
  </div>


</body>
</html>
