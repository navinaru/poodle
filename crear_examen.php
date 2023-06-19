<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POODLE</title>
  <link rel="stylesheet" href="style.css#2">
</head>
<body>
  
 
  <?php require './navbar.php'; ?>

  
  <div class="content">
    <p>
    <?php
require "./conn.php";
$conn = getconn();

// Obtener la lista de grupos
$sql = "SELECT id, nombreGrupo FROM grupos";
$result_grupos = mysqli_query($conn, $sql);

// Array para almacenar los grupos
$grupos = array();
while ($row = mysqli_fetch_assoc($result_grupos)) {
    $grupos[$row['id']] = $row['nombreGrupo'];
}

// Obtener la lista de categorias
$sql = "SELECT id, nombreCategoria FROM categoria";
$result_categorias = mysqli_query($conn, $sql);

// Array para almacenar las categorias
$categorias = array();
while ($row = mysqli_fetch_assoc($result_categorias)) {
    $categorias[$row['id']] = $row['nombreCategoria'];
}

// Comprobar si se ha enviado el formulario para crear un examen
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["create_examen"])) {
        // Obtener los datos del examen del formulario
        $titulo = $_POST["titulo"];
        $grupo = $_POST["grupo"];
        $fk_categoria = $_POST["fk_categoria"];
        $puntuacionTotal = $_POST["puntuacionTotal"];
        $borrado = isset($_POST["borrado"]) ? 1 : 0;
        $creador = $_SESSION["correo"];

        // Validar la entrada
        if (empty($titulo)) {
            echo "Se requiere un título.";
        } else {
            // Insertar el nuevo examen en la base de datos
            $sql = "INSERT INTO examenes (titulo, grupo, fk_categoria, puntuacionTotal, borrado, creador) VALUES ('$titulo', '$grupo', '$fk_categoria', '$puntuacionTotal', '$borrado', '$creador')";
            if (mysqli_query($conn, $sql)) {
                echo "Examen creado exitosamente.";
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
    <title>Crear Examen</title>
</head>
<body>
    <h2>Crear Examen</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" required>
        <br>
        <label for="grupo">Grupo:</label>
        <select name="grupo">
            <?php foreach ($grupos as $grupo_id => $nombreGrupo) { ?>
                <option value="<?php echo $grupo_id; ?>"><?php echo $nombreGrupo; ?></option>
            <?php } ?>
        </select>
        <br>
        <label for="fk_categoria">Categoría:</label>
        <select name="fk_categoria">
            <?php foreach ($categorias as $categoria_id => $nombreCategoria) { ?>
                <option value="<?php echo $categoria_id; ?>"><?php echo $nombreCategoria; ?></option>
            <?php } ?>
        </select>
        <br>
        <label for="puntuacionTotal">Puntuación Total:</label>
        <input type="text" name="puntuacionTotal">
        <br>
        <label for="borrado">Borrado:</label>
        <input type="checkbox" name="borrado" value="1">
        <br>
        <input type="hidden" name="creador" value="<?php echo $_SESSION['correo']; ?>">
        <input type="submit" name="create_examen" value="Crear Examen">
    </form>
</body>
</html>

    </p>
  </div>


</body>
</html>
