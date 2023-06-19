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

  <!-- Contenido del cuerpo -->
  <div class="content">
    <p>
    <?php
    require "./conn.php";
    $conn = getconn();

    // Verifica si el formulario se ha enviado para agregar/actualizar/eliminar una categoría
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["add_categoria"])) {
            // Obtiene los datos de la categoría del formulario
            $nombreCategoria = $_POST["nombreCategoria"];
            $fk_grupo = $_POST["fk_grupo"];

            // Valida la entrada
            if (empty($nombreCategoria)) {
                echo "Se requiere el nombre de la categoría.";
            } else {
                // Inserta la nueva categoría en la base de datos
                $sql = "INSERT INTO categoria (nombreCategoria, fk_grupo) VALUES ('$nombreCategoria', '$fk_grupo')";
                if (mysqli_query($conn, $sql)) {
                    // Actualiza la página después de agregar la categoría
                    header("Location: " . $_SERVER["PHP_SELF"]);
                    exit;
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        } elseif (isset($_POST["update_categoria"])) {
            // Obtiene los datos actualizados de la categoría del formulario
            $categoria_id = $_POST["categoria_id"];
            $updated_nombreCategoria = $_POST["updated_nombreCategoria"];
            $updated_fk_grupo = $_POST["updated_fk_grupo"];

            // Valida la entrada
            if (empty($updated_nombreCategoria)) {
                echo "Se requiere el nombre de la categoría.";
            } else {
                // Actualiza la categoría en la base de datos
                $sql = "UPDATE categoria SET nombreCategoria = '$updated_nombreCategoria', fk_grupo = '$updated_fk_grupo' WHERE id = '$categoria_id'";
                if (mysqli_query($conn, $sql)) {
                    // Actualiza la página después de actualizar la categoría
                    header("Location: " . $_SERVER["PHP_SELF"]);
                    exit;
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        } elseif (isset($_POST["delete_categoria"])) {
            // Obtiene el ID de la categoría a eliminar
            $categoria_id = $_POST["categoria_id"];

            // Elimina la categoría de la base de datos
            $sql = "DELETE FROM categoria WHERE id = '$categoria_id'";
            if (mysqli_query($conn, $sql)) {
                // Actualiza la página después de eliminar la categoría
                header("Location: " . $_SERVER["PHP_SELF"]);
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }

    // Obtiene las categorías existentes de la base de datos
    $sql = "SELECT categoria.id, categoria.nombreCategoria, grupos.nombreGrupo, grupos.id AS grupo_id
            FROM categoria
            INNER JOIN grupos ON categoria.fk_grupo = grupos.id";
    $result = mysqli_query($conn, $sql);

    // Array para almacenar las categorías existentes
    $categorias = array();

    if (mysqli_num_rows($result) > 0) {
        // Obtiene cada fila del conjunto de resultados
        while ($row = mysqli_fetch_assoc($result)) {
            $categorias[] = $row;
        }
    }

    // Obtiene los grupos existentes de la base de datos
    $sql = "SELECT * FROM grupos";
    $result = mysqli_query($conn, $sql);

    // Array para almacenar los grupos existentes
    $grupos = array();

    if (mysqli_num_rows($result) > 0) {
        // Obtiene cada fila del conjunto de resultados
        while ($row = mysqli_fetch_assoc($result)) {
            $grupos[$row['id']] = $row['nombreGrupo'];
        }
    }

    // Cierra la conexión a la base de datos
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Categorías</title>
</head>
<body>
    <h2>Agregar Categoría</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="nombreCategoria">Nombre de la Categoría:</label>
        <input type="text" name="nombreCategoria" required>
        <br>
        <label for="fk_grupo">Grupo:</label>
        <select name="fk_grupo">
            <?php foreach ($grupos as $grupo_id => $nombreGrupo) { ?>
                <option value="<?php echo $grupo_id; ?>"><?php echo $nombreGrupo; ?></option>
            <?php } ?>
        </select>
        <br>
        <input type="submit" name="add_categoria" value="Agregar Categoría">
    </form>

    <h2>Categorías</h2>
    <?php if (!empty($categorias)) { ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre de la Categoría</th>
                <th>Grupo</th>
                <th>Acción</th>
            </tr>
            <?php foreach ($categorias as $categoria) { ?>
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <tr>
                        <td><?php echo $categoria['id']; ?></td>
                        <td>
                            <input type="hidden" name="categoria_id" value="<?php echo $categoria['id']; ?>">
                            <input type="text" name="updated_nombreCategoria" value="<?php echo $categoria['nombreCategoria']; ?>" required>
                        </td>
                        <td>
                            <select name="updated_fk_grupo">
                                <?php foreach ($grupos as $grupo_id => $nombreGrupo) { ?>
                                    <option value="<?php echo $grupo_id; ?>" <?php if ($grupo_id == $categoria['grupo_id']) echo 'selected'; ?>><?php echo $nombreGrupo; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <input type="submit" name="update_categoria" value="Actualizar">
                            <input type="submit" name="delete_categoria" value="Eliminar" onclick="return confirm('¿Estás seguro de que quieres borrar esta categoría?')">
                        </td>
                    </tr>
                </form>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No hay categorías.</p>
    <?php } ?>


    </p>
  </div>


</body>
</html>

