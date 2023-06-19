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

 // Función para insertar un nuevo grupo
function insertGrupo($conn, $grupoName)
{
    // Construir la consulta SQL para insertar un nuevo grupo
    $sql = "INSERT INTO grupos (nombreGrupo) VALUES ('$grupoName')";

    // Ejecutar la consulta
    if (mysqli_query($conn, $sql)) {
        echo "Grupo añadido correctamente.";
    } else {
        echo "Error al añadir grupo: " . mysqli_error($conn);
    }
}

// Función para borrar un grupo
function deleteGrupo($conn, $grupoId)
{
    // Construir la consulta SQL para borrar un grupo
    $sql = "DELETE FROM grupos WHERE id = $grupoId";

    // Ejecutar la consulta
    if (mysqli_query($conn, $sql)) {
        echo "Grupo borrado correctamente.";
    } else {
        echo "Error al borrar grupo: " . mysqli_error($conn);
    }
}

// Función para editar un grupo
function editGrupo($conn, $grupoId, $newGroupName)
{
    // Construir la consulta SQL para editar un grupo
    $sql = "UPDATE grupos SET nombreGrupo = '$newGroupName' WHERE id = $grupoId";

    // Ejecutar la consulta
    if (mysqli_query($conn, $sql)) {
        echo "El grupo se ha actualizado correctamente.";
    } else {
        echo "Error al actualizar grupo: " . mysqli_error($conn);
    }
}

// Verificar si se ha enviado el formulario para insertar un grupo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["insert"])) {
    $grupoName = $_POST["grupo_name"];
    insertGrupo($conn, $grupoName);
}

// Verificar si se ha enviado el formulario para borrar un grupo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    $grupoId = $_POST["grupo_id"];
    deleteGrupo($conn, $grupoId);
}

// Verificar si se ha enviado el formulario para editar un grupo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit"])) {
    $grupoId = $_POST["edit_id"];
    $newGroupName = $_POST["edit_name"];
    editGrupo($conn, $grupoId, $newGroupName);
}

// Obtener todos los grupos de la tabla para mostrarlos
$sql = "SELECT * FROM grupos";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión</title>
</head>
<body>
    <h1>Gestión de grupos</h1>

    <!-- Formulario para insertar un nuevo grupo -->
    <h2>Añadir nuevo grupo:</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="grupo_name">Nombre del grupo:</label>
        <input type="text" name="grupo_name" id="grupo_name">
        <input type="submit" name="insert" value="Añadir">
    </form>

    <!-- Mostrar los grupos existentes -->
    <h2>Listado de Grupos</h2>
    <?php if (mysqli_num_rows($result) > 0) : ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Grupo</th>
                <th>Borrar</th>
                <th>Editar</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
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
        <p>No hay grupos.</p>
    <?php endif; ?>

</body>
</html>

<?php
// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
