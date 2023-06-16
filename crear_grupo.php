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
  $conn = mysqli_connect("localhost", "root", "", "proyecto");

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

 // Function to insert a new grupo
function insertGrupo($conn, $grupoName)
{
    // Construct the SQL query to insert a new grupo
    $sql = "INSERT INTO grupos (nombreGrupo) VALUES ('$grupoName')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Grupo añadido correctamente!.";
    } else {
        echo "Error al añadir grupo" . $conn->error;
    }
}

// Function to delete a grupo
function deleteGrupo($conn, $grupoId)
{
    // Construct the SQL query to delete a grupo
    $sql = "DELETE FROM grupos WHERE id = $grupoId";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Grupo borrado correctamente.";
    } else {
        echo "Error al borrar grupo. " . $conn->error;
    }
}

// Function to edit a grupo
function editGrupo($conn, $grupoId, $newGroupName)
{
    // Construct the SQL query to edit a grupo
    $sql = "UPDATE grupos SET nombreGrupo = '$newGroupName' WHERE id = $grupoId";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "EL grupo se a actualizado.";
    } else {
        echo "Error al actualizar grupo." . $conn->error;
    }
}

// Check if form data was submitted for insertion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["insert"])) {
    $grupoName = $_POST["grupo_name"];
    insertGrupo($conn, $grupoName);
}

// Check if form data was submitted for deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    $grupoId = $_POST["grupo_id"];
    deleteGrupo($conn, $grupoId);
}

// Check if form data was submitted for editing
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit"])) {
    $grupoId = $_POST["edit_id"];
    $newGroupName = $_POST["edit_name"];
    editGrupo($conn, $grupoId, $newGroupName);
}

// Retrieve all grupos from the table for display
$sql = "SELECT * FROM grupos";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>gestion</title>
</head>
<body>
    <h1>Gestion de grupos</h1>

    <!-- Form for inserting a new grupo -->
    <h2>Añadir nuevo grupo:</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="grupo_name">Nombre grupo:</label>
        <input type="text" name="grupo_name" id="grupo_name">
        <input type="submit" name="insert" value="añadir">
    </form>

    <!-- Display existing grupos -->
    <h2>Listado de Grupos</h2>
    <?php if ($result->num_rows > 0) : ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Grupo:</th>
                <th>Borrar</th>
                <th>Editar</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombreGrupo']; ?></td>
                    <td>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="grupo_id" value="<?php echo $row['id']; ?>">
                            <input type="submit" name="delete" value="Borrar">
                        </form>
                    </td>
                    <td>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                            <input type="text" name="edit_name" placeholder="Insertar nombre">
                            <input type="submit" name="edit" value="Editar">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else : ?>
        <p>No hay grupos!</p>
    <?php endif; ?>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>

