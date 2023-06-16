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
// Database connection

    $conn = mysqli_connect("localhost", "root", "", "proyecto");

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

// Update user data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $tipoUsuario = $_POST['tipoUsuario'];
    $grupo = $_POST['grupo'];

    $sql = "UPDATE usuarios SET password='$password', nombre='$nombre', apellidos='$apellidos', tipoUsuario='$tipoUsuario', grupo='$grupo' WHERE correo='$correo'";
    if ($conn->query($sql) === TRUE) {
        echo "User updated successfully.";
    } else {
        echo "Error updating user: " . $conn->error;
    }
}

// Fetch users data
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    ?>
    <table>
        <tr>
            <th>Correo</th>
            <th>Contraseña</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Tipo Usuario</th>
            <th>Grupo</th>
            <th></th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            $correo = $row['correo'];
            $password = $row['password'];
            $nombre = $row['nombre'];
            $apellidos = $row['apellidos'];
            $tipoUsuario = $row['tipoUsuario'];
            $grupo = $row['grupo'];
            ?>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <tr>
                    <td><input type="text" name="correo" value="<?php echo $correo; ?>" readonly></td>
                    <td><input type="text" name="password" value="<?php echo $password; ?>"></td>
                    <td><input type="text" name="nombre" value="<?php echo $nombre; ?>"></td>
                    <td><input type="text" name="apellidos" value="<?php echo $apellidos; ?>"></td>
                    <td>
                        <select name="tipoUsuario">
                            <option value="3" <?php if ($tipoUsuario == 3) echo 'selected'; ?>>Administrador</option>
                            <option value="2" <?php if ($tipoUsuario == 2) echo 'selected'; ?>>Profesorado</option>
                            <option value="1" <?php if ($tipoUsuario == 1) echo 'selected'; ?>>Alumno</option>
                        </select>
                    </td>
                    <td>
                        <select name="grupo">
                            <?php
                            $sqlGrupos = "SELECT * FROM grupos";
                            $resultGrupos = $conn->query($sqlGrupos);

                            if ($resultGrupos->num_rows > 0) {
                                while ($rowGrupo = $resultGrupos->fetch_assoc()) {
                                    $idGrupo = $rowGrupo['id'];
                                    $nombreGrupo = $rowGrupo['nombreGrupo'];
                                    ?>
                                    <option value="<?php echo $idGrupo; ?>" <?php if ($grupo == $idGrupo) echo 'selected'; ?>><?php echo $nombreGrupo; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td><input type="submit" value="Actualizar"></td>
                </tr>
            </form>
            <?php
        }
        ?>
    </table>
    <?php
} else {
    echo "Error en devolver usuarios comprobar query php";
}

$conn->close();
?>

    </p>
  </div>


</body>
</html>

