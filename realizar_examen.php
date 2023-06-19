<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POODLE</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  
 
  <?php require './navbar.php'; ?>

  
  <div class="content">
    <p>
    <?php



    require "./conn.php";
    $conn = getconn();


if (isset($_GET['id'])) {
    $examId = $_GET['id'];

    
    $query = "SELECT pregunta.id, pregunta.enunciado, pregunta.respuestaA, pregunta.respuestaB, pregunta.respuestaC, pregunta.respuestaD, preguntas_examenes.puntuacion
              FROM pregunta
              INNER JOIN preguntas_examenes ON pregunta.id = preguntas_examenes.pregunta
              WHERE preguntas_examenes.examen = '$examId'";
    $result = mysqli_query($conn, $query);

    
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
    echo '<input type="submit" name="submit" value="Entregar">';
    echo '</form>';

    
    if (isset($_POST['submit'])) {
        $suma_correcto = 0;

        
        $selectedAnswers = $_POST['answers'];

        foreach ($selectedAnswers as $selectedAnswer => $value) {
            
            $query = "SELECT pregunta.id, pregunta.correcto, preguntas_examenes.puntuacion, preguntas_examenes.pregunta 
            FROM pregunta
            INNER JOIN preguntas_examenes ON pregunta.id = preguntas_examenes.pregunta
            WHERE (pregunta.respuestaA = '$selectedAnswer' OR pregunta.respuestaB = '$selectedAnswer' OR pregunta.respuestaC = '$selectedAnswer' OR pregunta.respuestaD = '$selectedAnswer')
            AND preguntas_examenes.examen = '$examId'";

            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $questionId = $row['pregunta'];
            $correctAnswer = $row['correcto'];
            echo "elegiste:". $selectedAnswer;
            echo "</br>";
            echo "solución:" . $correctAnswer;
            echo "</br>";

            if ($selectedAnswer == $correctAnswer) {
                
                $query = "SELECT puntuacion FROM preguntas_examenes WHERE examen = '$examId' AND pregunta = '$questionId'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $puntuacion = $row['puntuacion'];

                
                $suma_correcto += $puntuacion;
            }
        }

        
        $usuario = $_SESSION['correo'];
        $insertQuery = "INSERT INTO examenes_usuarios (examen, usuario, nota) VALUES ('$examId', '$usuario', '$suma_correcto')";
        mysqli_query($conn, $insertQuery);

        
        echo "<p>Tu nota: $suma_correcto</p>";

        
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
