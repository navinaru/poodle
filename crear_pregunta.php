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
require "./conn.php";
$conn = getconn();

// Obtener la lista de categorías
$sql = "SELECT id, nombreCategoria FROM categoria";
$result_categorias = mysqli_query($conn, $sql);

// Array para almacenar las categorías
$categorias = array();
while ($row = mysqli_fetch_assoc($result_categorias)) {
    $categorias[$row['id']] = $row['nombreCategoria'];
}

// Verificar si se ha enviado el formulario para crear una pregunta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["create_pregunta"])) {
        // Obtener los datos de la pregunta del formulario
        $enunciado = $_POST["enunciado"];
        $respuestaA = $_POST["respuestaA"];
        $respuestaB = $_POST["respuestaB"];
        $respuestaC = $_POST["respuestaC"];
        $respuestaD = $_POST["respuestaD"];
        $categoria = $_POST["categoria"];
        $correcto = $_POST["correcto"];

        // Validar la entrada
        if (empty($enunciado) || empty($respuestaA) || empty($respuestaB) || empty($respuestaC) || empty($respuestaD)) {
            echo "Todos los campos son obligatorios.";
        } elseif ($correcto !== $respuestaA && $correcto !== $respuestaB && $correcto !== $respuestaC && $correcto !== $respuestaD) {
            echo "Una de las opciones debe coincidir con la respuesta correcta.";
        } else {
            // Insertar la nueva pregunta en la base de datos
            $sql = "INSERT INTO pregunta (enunciado, respuestaA, respuestaB, respuestaC, respuestaD, categoria, correcto) VALUES ('$enunciado', '$respuestaA', '$respuestaB', '$respuestaC', '$respuestaD', '$categoria', '$correcto')";
            if (mysqli_query($conn, $sql)) {
                echo "Pregunta creada correctamente.";
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
    <title>Crear Pregunta</title>
</head>
<body>
    <h2>Crear Pregunta</h2>
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
        <label for="categoria">Categoría:</label>
        <select name="categoria">
            <?php foreach ($categorias as $categoria_id => $nombreCategoria) { ?>
                <option value="<?php echo $categoria_id; ?>"><?php echo $nombreCategoria; ?></option>
            <?php } ?>
        </select>
        <br>
        <label for="correcto">Respuesta correcta:</label>
        <input type="text" name="correcto" required>
        <br>
        <input type="submit" name="create_pregunta" value="Crear Pregunta">
    </form>

    </p>
  </div>

</body>
</html>
