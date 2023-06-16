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

    
    if (isset($_GET)) {
        $asignatura = $_GET['id'];

        $conn = mysqli_connect("localhost", "root", "", "proyecto");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
                $query = "SELECT *
                FROM examenes
                WHERE fk_categoria = " . $asignatura;

        // Execute the query
        $result = $conn->query($query);

        // Check if the query executed successfully
        if ($result) {
        // Fetch and display the rows
        while ($row = $result->fetch_assoc()) {
            $titulo = $row['titulo'];
            echo '<h2><a href="realizar_examen.php?id=' .$row['id'].'"> '.$titulo.'</a><br>';
        }

        // Free the result set
        $result->free();
        } else {
        // Handle query error
        echo "Query error: " . $conn->error;
        }

        // Close the database connection
        $conn->close();

    }
    else {
        echo "<h2>error de direccionamiento</h2>";
    }
?>


    </p>
  </div>


</body>
</html>