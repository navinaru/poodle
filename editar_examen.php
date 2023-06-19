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

    $sql = "SELECT id, nombreGrupo FROM grupos";
    $result_grupos = mysqli_query($conn, $sql);
    $grupos = array();
    while ($row = mysqli_fetch_assoc($result_grupos)) {
        $grupos[$row['id']] = $row['nombreGrupo'];
    }
    $sql = "SELECT id, nombreCategoria FROM categoria";
    $result_categorias = mysqli_query($conn, $sql);
    $categorias = array();
    while ($row = mysqli_fetch_assoc($result_categorias)) {
        $categorias[$row['id']] = $row['nombreCategoria'];
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["update_examen"])) {
            $examen_id = $_POST["examen_id"];
            $titulo = $_POST["titulo"];
            $grupo = $_POST["grupo"];
            $fk_categoria = $_POST["fk_categoria"];
            $puntuacionTotal = $_POST["puntuacionTotal"];
            $borrado = isset($_POST["borrado"]) ? 1 : 0;
            $sql = "UPDATE examenes SET titulo='$titulo', grupo='$grupo', fk_categoria='$fk_categoria', puntuacionTotal='$puntuacionTotal', borrado='$borrado' WHERE id='$examen_id'";
            if (mysqli_query($conn, $sql)) {
                echo "Examen entry updated successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }
    $sql = "SELECT * FROM examenes";
    $result_examenes = mysqli_query($conn, $sql);
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Examenes</title>
</head>
<body>
    <h2>Editar Examenes</h2>
    <table>
        <tr>
            <th>Titulo</th>
            <th>Grupo</th>
            <th>Categoria</th>
            <th>Puntuacion Total</th>
            <th>Borrado</th>
            <th>Edit</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result_examenes)) { ?>
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
                        <input type="submit" name="update_examen" value="actualizar">
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
