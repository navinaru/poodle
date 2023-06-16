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

// Retrieve the list of grupos
$sql = "SELECT id, nombreGrupo FROM grupos";
$result_grupos = $conn->query($sql);

// Array to store the grupos
$grupos = array();
while ($row = $result_grupos->fetch_assoc()) {
    $grupos[$row['id']] = $row['nombreGrupo'];
}

// Retrieve the list of categorias
$sql = "SELECT id, nombreCategoria FROM categoria";
$result_categorias = $conn->query($sql);

// Array to store the categorias
$categorias = array();
while ($row = $result_categorias->fetch_assoc()) {
    $categorias[$row['id']] = $row['nombreCategoria'];
}

// Check if the form is submitted for updating an examen entry
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["update_examen"])) {
        // Retrieve the examen data from the form
        $examen_id = $_POST["examen_id"];
        $titulo = $_POST["titulo"];
        $grupo = $_POST["grupo"];
        $fk_categoria = $_POST["fk_categoria"];
        $puntuacionTotal = $_POST["puntuacionTotal"];
        $borrado = isset($_POST["borrado"]) ? 1 : 0;

        // Update the examen entry in the database
        $sql = "UPDATE examenes SET titulo='$titulo', grupo='$grupo', fk_categoria='$fk_categoria', puntuacionTotal='$puntuacionTotal', borrado='$borrado' WHERE id='$examen_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Examen entry updated successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Retrieve the examen entries from the database
$sql = "SELECT * FROM examenes";
$result_examenes = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Examenes</title>
</head>
<body>
    <h2>Manage Examenes</h2>
    <table>
        <tr>
            <th>Titulo</th>
            <th>Grupo</th>
            <th>FK Categoria</th>
            <th>Puntuacion Total</th>
            <th>Borrado</th>
            <th>Edit</th>
        </tr>
        <?php while ($row = $result_examenes->fetch_assoc()) { ?>
            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <tr>
                    <td>
                        <input type="text" name="titulo" value="<?php echo $row['titulo']; ?>">
                    </td>
                    <td>
                        <select name="grupo">
                            <?php foreach ($grupos as $grupo_id => $nombreGrupo) { ?>
                                <option value="<?php echo $grupo_id; ?>" <?php if ($grupo_id == $row['grupo']) echo "selected"; ?>><?php echo $nombreGrupo; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="fk_categoria">
                            <?php foreach ($categorias as $categoria_id => $nombreCategoria) { ?>
                                <option value="<?php echo $categoria_id; ?>" <?php if ($categoria_id == $row['fk_categoria']) echo "selected"; ?>><?php echo $nombreCategoria; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="puntuacionTotal" value="<?php echo $row['puntuacionTotal']; ?>">
                    </td>
                    <td>
                        <input type="checkbox" name="borrado" <?php if ($row['borrado'] == 1) echo "checked"; ?>>
                    </td>
                    <td>
                        <input type="hidden" name="examen_id" value="<?php echo $row['id']; ?>">
                        <input type="submit" name="update_examen" value="Update">
                    </td>
                </tr>
            </form>
        <?php } ?>
    </table>
</body>
</html>

    </p>
  </div>


</body>
</html>

