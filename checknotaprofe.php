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
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "proyecto");

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

// Function to sanitize input
function sanitizeInput($input)
{
    return htmlspecialchars(stripslashes(trim($input)));
}

// Update the nota field
if (isset($_POST['update'])) {
    $nota = sanitizeInput($_POST['nota']);
    $id = sanitizeInput($_POST['id']);

    // Validate nota as a number
    if (!is_numeric($nota)) {
        echo "Nota should be a number.";
    } else {
        $sql = "UPDATE examenes_usuarios SET nota = $nota WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error updating nota: " . $conn->error;
        }
    }
}

// Fetch and display the data
$sql = "SELECT examenes_usuarios.id, examenes.titulo, examenes_usuarios.usuario, examenes_usuarios.nota 
        FROM examenes_usuarios
        INNER JOIN examenes ON examenes_usuarios.examen = examenes.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Examenes Usuarios</title>
</head>
<body>
    <h1>Edit Examenes Usuarios</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Examen</th>
            <th>Usuario</th>
            <th>Nota</th>
            <th>Update</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['titulo']; ?></td>
                <td><?php echo $row['usuario']; ?></td>
                <td><input type="text" name="nota" value="<?php echo $row['nota']; ?>"></td>
                <td>
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="submit" name="update" value="Update">
                </td>
            </form>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>


    </p>
  </div>


</body>
</html>

