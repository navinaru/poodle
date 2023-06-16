<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Moodle Site</title>
  <link rel="stylesheet" href="style.css">
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

        // Retrieve rows from the 'categoria' table
        $sql = "SELECT nombreCategoria , id FROM categoria WHERE fk_grupo = ".$_SESSION['grupo'];
        $result = $conn->query($sql);

        // Display formatted HTML boxes
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="box">'; // Box style
                echo '<h2><a href="examenes.php?id=' .$row['id'].'"> '. $row['nombreCategoria'] . '</a></h2>';
                echo '</div>';
            }
        } else {
            echo "<h2>No esta registrado en ningun curso, comunique al administrador si crees que esto es un error</h2>";
            echo print_r($result) ;
        }

        // Close the database connection
        $conn->close();
        ?>
    </p>
    </div>


    </body>
    </html>
