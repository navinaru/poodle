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
        require "./conn.php";
        $conn = getconn();

        // Obtener filas de la tabla 'categoria'
        $sql = "SELECT nombreCategoria, id FROM categoria WHERE fk_grupo = ".$_SESSION['grupo'];
        $result = mysqli_query($conn, $sql);

        // Mostrar cuadros HTML formateados
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="box">'; 
                echo '<h2><a href="examenes.php?id=' .$row['id'].'"> '. $row['nombreCategoria'] . '</a></h2>';
                echo '</div>';
            }
        } else {
            echo "<h2>No está registrado en ningún curso, comuníquese con el administrador si cree que esto es un error</h2>";
            echo print_r($result);
        }

        // Cerrar la conexión a la base de datos
        mysqli_close($conn);
        ?>
    </p>
    </div>


    </body>
    </html>
