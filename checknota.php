<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POODLE</title>
  <style>
    .pagination {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .pagination ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .pagination li {
        display: inline-block;
        margin-right: 5px;
    }

    .pagination li a {
        display: block;
        padding: 5px 10px;
        background-color: #f2f2f2;
        color: #333;
        text-decoration: none;
        border-radius: 3px;
    }

    .pagination li.active a {
        background-color: #333;
        color: #fff;
    }

    .pagination li a:hover {
        background-color: #ddd;
    }
</style>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Top Navigation Bar -->
 
  <?php require './navbar.php'; ?>

  <!-- Body Content -->
  <div class="content">
    <p>
        <?php
        // Assuming you have established a database connection

        $conn = mysqli_connect("localhost", "root", "", "proyecto");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve the user's email from the session variable
        $userEmail = $_SESSION['correo'];

        // Query to fetch the total number of exam result records
        $countQuery = "SELECT COUNT(*) AS total FROM (SELECT DISTINCT categoria.nombreCategoria
            FROM categoria
            JOIN examenes ON examenes.fk_categoria = categoria.id
            JOIN examenes_usuarios ON examenes_usuarios.examen = examenes.id
            WHERE examenes_usuarios.usuario = '$userEmail') AS result_count";

        $countResult = mysqli_query($conn, $countQuery);
        $totalCount = mysqli_fetch_assoc($countResult)['total'];

        // Define the number of records to display per page
        $recordsPerPage = 3;

        // Calculate the total number of pages
        $totalPages = ceil($totalCount / $recordsPerPage);

        // Get the current page number
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

        // Calculate the offset for the query
        $offset = ($currentPage - 1) * $recordsPerPage;

        // Query to fetch the exam results by category with pagination
        $query = "SELECT categoria.nombreCategoria, examenes.titulo, examenes_usuarios.usuario, examenes_usuarios.nota 
            FROM categoria
            JOIN examenes ON examenes.fk_categoria = categoria.id
            JOIN examenes_usuarios ON examenes_usuarios.examen = examenes.id
            WHERE examenes_usuarios.usuario = '$userEmail'
            GROUP BY categoria.nombreCategoria
            ORDER BY categoria.id
            LIMIT $offset, $recordsPerPage";

        $result = mysqli_query($conn, $query);

        // Initialize a variable to keep track of the current category
        $currentCategory = "";

        // Iterate over the result set
        while ($row = mysqli_fetch_assoc($result)) {
            $category = $row['nombreCategoria'];
            $examTitle = $row['titulo'];
            $username = $row['usuario'];
            $grade = $row['nota'];

            // If the category changes, start a new category block
            if ($currentCategory != $category) {
                if ($currentCategory != "") {
                    echo '</ul></div>';
                }

                echo '<div><h2>' . $category . '</h2><ul>';
                $currentCategory = $category;
            }

            // Display the exam result
            echo '<li>Nome da proba: ' . $examTitle . '</li>';
            echo '<li>asignatura: ' . $category . '</li>';
            echo '<li>Usuario: ' . $username . '</li>';
            echo '<li>Nota: ' . $grade . '</li>';
            echo '</br>';
        }

        // Close the last category block
        if ($currentCategory != "") {
            echo '</ul></div>';
        }

        // Display pagination links
        echo '<div class="pagination">';
        if ($totalPages > 1) {
            echo '<ul>';

            // Previous page link
            if ($currentPage > 1) {
                $prevPage = $currentPage - 1;
                echo '<li><a href="?page=' . $prevPage . '">Previous</a></li>';
            }

            // Page links
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i == $currentPage) {
                    echo '<li class="active"><a href="?page=' . $i . '">' . $i . '</a></li>';
                } else {
                    echo '<li><a href="?page=' . $i . '">' . $i . '</a></li>';
                }
            }

            // Next page link
            if ($currentPage < $totalPages) {
                $nextPage = $currentPage + 1;
                echo '<li><a href="?page=' . $nextPage . '">Next</a></li>';
            }

            echo '</ul>';
        }
        echo '</div>';

        // Close the database connection
        mysqli_close($conn);
        ?>
    </p>
</div>



</body>
</html>

