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


// Assuming you have established a database conn using mysqli
$conn = mysqli_connect("localhost", "root", "", "proyecto");

// Check conn
if ($conn->connect_error) {
    die("conn failed: " . $conn->connect_error);
}

// Check if the 'id' parameter is provided in the $_GET array
if (isset($_GET['id'])) {
    $examId = $_GET['id'];

    // Retrieve the questions and answers for the specific exam
    $query = "SELECT pregunta.id, pregunta.enunciado, pregunta.respuestaA, pregunta.respuestaB, pregunta.respuestaC, pregunta.respuestaD, preguntas_examenes.puntuacion
              FROM pregunta
              INNER JOIN preguntas_examenes ON pregunta.id = preguntas_examenes.pregunta
              WHERE preguntas_examenes.examen = '$examId'";
    $result = mysqli_query($conn, $query);

    // Display the questions and answers
    echo '<form method="post" action="">';
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $enunciado = $row['enunciado'];
        $respuestaA = $row['respuestaA'];
        $respuestaB = $row['respuestaB'];
        $respuestaC = $row['respuestaC'];
        $respuestaD = $row['respuestaD'];

        echo '<div class="pregunta">';
        echo "<p>$enunciado</p>";
        echo "</br>";
        echo "<label><input type='checkbox' name='answers[$respuestaA]' value='A'> $respuestaA</label><br>";
        echo "<label><input type='checkbox' name='answers[$respuestaB]' value='B'> $respuestaB</label><br>";
        echo "<label><input type='checkbox' name='answers[$respuestaC]' value='C'> $respuestaC</label><br>";
        echo "<label><input type='checkbox' name='answers[$respuestaD]' value='D'> $respuestaD</label><br><br>";
        echo "</div>";
    }
    echo '<input type="submit" name="submit" value="Submit">';
    echo '</form>';

    // Handle form submission
    if (isset($_POST['submit'])) {
        $suma_correcto = 0;

        // Get the selected answers
        $selectedAnswers = $_POST['answers'];

        foreach ($selectedAnswers as $selectedAnswer => $value) {
            // Retrieve the correct answer for the question
            $query = "SELECT pregunta.id, pregunta.correcto, preguntas_examenes.puntuacion, preguntas_examenes.pregunta 
            FROM pregunta
            INNER JOIN preguntas_examenes ON pregunta.id = preguntas_examenes.pregunta
            WHERE (pregunta.respuestaA = '$selectedAnswer' OR pregunta.respuestaB = '$selectedAnswer' OR pregunta.respuestaC = '$selectedAnswer' OR pregunta.respuestaD = '$selectedAnswer')
            AND preguntas_examenes.examen = '$examId'";

            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $questionId = $row['pregunta'];
            $correctAnswer = $row['correcto'];
            echo $selectedAnswer;
            echo "</br>";
            echo $correctAnswer;
            echo "</br>";

            if ($selectedAnswer == $correctAnswer) {
                // Retrieve the question's score
                $query = "SELECT puntuacion FROM preguntas_examenes WHERE examen = '$examId' AND pregunta = '$questionId'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $puntuacion = $row['puntuacion'];

                // Add the score to the total
                $suma_correcto += $puntuacion;
            }
        }

        // Insert entry into examenes_usuarios table
        $usuario = $_SESSION['correo'];
        $insertQuery = "INSERT INTO examenes_usuarios (examen, usuario, nota) VALUES ('$examId', '$usuario', '$suma_correcto')";
        mysqli_query($conn, $insertQuery);

        // Display the final score
        echo "<p>Your score: $suma_correcto</p>";

        // Close the database conn
        mysqli_close($conn);
    }
} else {
    echo "Fallo al recuperar el id del examen, perdón!";
}
?>



    </p>
  </div>


</body>
</html>
