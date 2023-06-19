<!DOCTYPE html>
<html lang="es">
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

    // Actualizar datos del usuario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $correo = $_POST['correo'];
        $password = $_POST['password'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $tipoUsuario = $_POST['tipoUsuario'];
        $grupo = $_POST['grupo'];

        $sql = "UPDATE usuarios SET password='$password', nombre='$nombre', apellidos='$apellidos', tipoUsuario='$tipoUsuario', grupo='$grupo' WHERE correo='$correo'";
        if (mysqli_query($conn, $sql)) {
            echo "Usuario actualizado correctamente.";
        } else {
            echo "Error al actualizar el usuario: " . mysqli_error($conn);
        }
    }

    // Obtener datos de los usuarios
    $sql = "SELECT * FROM usuarios";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        ?>
        <table>
            <tr>
                <th>Correo</th>
                <th>Contraseña</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Tipo de Usuario</th>
                <th>Grupo</th>
                <th></th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
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
                                $resultGrupos = mysqli_query($conn, $sqlGrupos);

                                if (mysqli_num_rows($resultGrupos) > 0) {
                                    while ($rowGrupo = mysqli_fetch_assoc($resultGrupos)) {
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
        echo "Error al recuperar los usuarios. Comprueba la consulta en PHP.";
    }

    mysqli_close($conn);
    ?>

    </p>
  </div>
</body>
</html>
