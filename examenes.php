<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Moodle Site</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
 
 
  <?php require './navbar.php'; ?>


  <div class="content">
    <p>
    <?php
if (isset($_GET)) {
    $asignatura = $_GET['id'];

    require "./conn.php";
    $conn = getconn();

    $query = "SELECT *
              FROM examenes
              WHERE fk_categoria = " . $asignatura . " AND borrado != 1";

    // Ejecuta la consulta
    $result = mysqli_query($conn, $query);

    // Verifica si la consulta se ejecutó correctamente
    if ($result) {
        // Recorre y muestra las filas
        while ($row = mysqli_fetch_assoc($result)) {
            $titulo = $row['titulo'];
            echo '<h4><a href="realizar_examen.php?id=' . $row['id'] . '"><img src="./recursos/icon.svg" alt="Icon">' . $titulo . '</a><br>';
        }

        // Libera el conjunto de resultados
        mysqli_free_result($result);
    } else {
        // Maneja el error de la consulta
        echo "Error en la consulta: " . mysqli_error($conn);
    }

    // Cierra la conexión a la base de datos
    mysqli_close($conn);
} else {
    echo "<h2>error de direccionamiento</h2>";
}
?>




    </p>
  </div>


</body>
</html>