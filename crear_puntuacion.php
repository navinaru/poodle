<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POODLE</title>
  <link rel="stylesheet" href="style.css#2">
</head>
<body>
  <!-- Barra de navegación superior -->
 
  <?php require './navbar.php'; ?>

  <!-- Contenido principal -->
  <div class="content">
    <p>
    <?php
// Configuración de conexión a la base de datos
$conn = mysqli_connect("localhost", "root", "", "proyecto");

// Verificar conexión
if (mysqli_connect_errno()) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener la lista de exámenes
$sql = "SELECT id, titulo FROM examenes";
$result_examenes = mysqli_query($conn, $sql);

// Array para almacenar los exámenes
$examenes = array();
while ($row = mysqli_fetch_assoc($result_examenes)) {
    $examenes[$row['id']] = $row['titulo'];
}

// Obtener la lista de preguntas
$sql = "SELECT id, enunciado FROM pregunta";
$result_preguntas = mysqli_query($conn, $sql);

// Array para almacenar las preguntas
$preguntas = array();
while ($row = mysqli_fetch_assoc($result_preguntas)) {
    $preguntas[$row['id']] = $row['enunciado'];
}

// Verificar si se ha enviado el formulario para crear una entrada preguntas_examenes
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["create_preguntas_examenes"])) {
        // Obtener los datos de preguntas_examenes del formulario
        $examen = $_POST["examen"];
        $pregunta = $_POST["pregunta"];
        $puntuacion = $_POST["puntuacion"];

        // Validar la entrada
        if (!is_numeric($puntuacion)) {
            echo "La puntuación debe ser un número.";
        } else {
            // Insertar la nueva entrada preguntas_examenes en la base de datos
            $sql = "INSERT INTO preguntas_examenes (examen, pregunta, puntuacion) VALUES ('$examen', '$pregunta', '$puntuacion')";
            if (mysqli_query($conn, $sql)) {
                echo "Entrada preguntas_examenes creada correctamente.";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Crear Preguntas </title>
</head>
<body>
    <h2>Crear Preguntas </h2>
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
        <label for="puntuacion">Puntuación:</label>
        <input type="text" name="puntuacion" required>
        <br>
        <input type="submit" name="create_preguntas_examenes" value="Crear Pregunta">
    </form>
</body>
</html>
