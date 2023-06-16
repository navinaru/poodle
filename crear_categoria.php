<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POODLE</title>
  <link rel="stylesheet" href="style.css#2">
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

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted for adding/updating/deleting a categoria
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_categoria"])) {
        // Retrieve the categoria data from the form
        $nombreCategoria = $_POST["nombreCategoria"];
        $fk_grupo = $_POST["fk_grupo"];

        // Validate the input
        if (empty($nombreCategoria)) {
            echo "Category name is required.";
        } else {
            // Insert the new categoria into the database
            $sql = "INSERT INTO categoria (nombreCategoria, fk_grupo) VALUES ('$nombreCategoria', '$fk_grupo')";
            if ($conn->query($sql) === TRUE) {
                // Refresh the page after adding the categoria
                header("Location: " . $_SERVER["PHP_SELF"]);
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } elseif (isset($_POST["update_categoria"])) {
        // Retrieve the updated categoria data from the form
        $categoria_id = $_POST["categoria_id"];
        $updated_nombreCategoria = $_POST["updated_nombreCategoria"];
        $updated_fk_grupo = $_POST["updated_fk_grupo"];

        // Validate the input
        if (empty($updated_nombreCategoria)) {
            echo "Category name is required.";
        } else {
            // Update the categoria in the database
            $sql = "UPDATE categoria SET nombreCategoria = '$updated_nombreCategoria', fk_grupo = '$updated_fk_grupo' WHERE id = '$categoria_id'";
            if ($conn->query($sql) === TRUE) {
                // Refresh the page after updating the categoria
                header("Location: " . $_SERVER["PHP_SELF"]);
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } elseif (isset($_POST["delete_categoria"])) {
        // Retrieve the categoria ID to be deleted
        $categoria_id = $_POST["categoria_id"];

        // Delete the categoria from the database
        $sql = "DELETE FROM categoria WHERE id = '$categoria_id'";
        if ($conn->query($sql) === TRUE) {
            // Refresh the page after deleting the categoria
            header("Location: " . $_SERVER["PHP_SELF"]);
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Retrieve the existing categorias from the database
$sql = "SELECT categoria.id, categoria.nombreCategoria, grupos.nombreGrupo, grupos.id AS grupo_id
        FROM categoria
        INNER JOIN grupos ON categoria.fk_grupo = grupos.id";
$result = $conn->query($sql);

// Array to store the existing categorias
$categorias = array();

if ($result->num_rows > 0) {
    // Fetch each row from the result set
    while ($row = $result->fetch_assoc()) {
        $categorias[] = $row;
    }
}

// Retrieve the existing grupos from the database
$sql = "SELECT * FROM grupos";
$result = $conn->query($sql);

// Array to store the existing grupos
$grupos = array();

if ($result->num_rows > 0) {
    // Fetch each row from the result set
    while ($row = $result->fetch_assoc()) {
        $grupos[$row['id']] = $row['nombreGrupo'];
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>
</head>
<body>
    <h2>Add Category</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="nombreCategoria">Category Name:</label>
        <input type="text" name="nombreCategoria" required>
        <br>
        <label for="fk_grupo">Grupo:</label>
        <select name="fk_grupo">
            <?php foreach ($grupos as $grupo_id => $nombreGrupo) { ?>
                <option value="<?php echo $grupo_id; ?>"><?php echo $nombreGrupo; ?></option>
            <?php } ?>
        </select>
        <br>
        <input type="submit" name="add_categoria" value="Add Category">
    </form>

    <h2>Categories</h2>
    <?php if (!empty($categorias)) { ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Grupo</th>
                <th>Action</th>
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
                            <input type="submit" name="update_categoria" value="Update">
                            <input type="submit" name="delete_categoria" value="Delete" onclick="return confirm('Estas seguro de que quieres borrar esta categoria?')">
                        </td>
                    </tr>
                </form>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No hay categorias.</p>
    <?php } ?>


    </p>
  </div>


</body>
</html>
