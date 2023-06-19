<!DOCTYPE html>
<html lang="es">
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
  <!-- Barra de navegación superior -->
 
  <?php require './navbar.php'; ?>

  <!-- Contenido principal -->
  <div class="content">
    <p>
    <?php
// Suponiendo que has establecido una conexión a la base de datos

$conn = mysqli_connect("localhost", "root", "", "proyecto");

// Verificar la conexión
if (mysqli_connect_errno()) {
    die("La conexión falló: " . mysqli_connect_error());
}

// Obtener el correo electrónico del usuario desde la variable de sesión
$userEmail = $_SESSION['correo'];

// Consulta para obtener el número total de registros de resultados de exámenes
$countQuery = "SELECT COUNT(*) AS total FROM categoria
    JOIN examenes ON examenes.fk_categoria = categoria.id
    JOIN examenes_usuarios ON examenes_usuarios.examen = examenes.id
    WHERE examenes_usuarios.usuario = '$userEmail'";

$countResult = mysqli_query($conn, $countQuery);
$totalCount = mysqli_fetch_assoc($countResult)['total'];

// Definir la cantidad de registros a mostrar por página
$recordsPerPage = 3;

// Calcular el número total de páginas
$totalPages = ceil($totalCount / $recordsPerPage);

// Obtener el número de página actual
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

// Calcular el desplazamiento para la consulta
$offset = ($currentPage - 1) * $recordsPerPage;

// Consulta para obtener todos los resultados de exámenes por categoría para el usuario con paginación
$query = "SELECT categoria.nombreCategoria, examenes.titulo, examenes_usuarios.usuario, examenes_usuarios.nota 
    FROM categoria
    JOIN examenes ON examenes.fk_categoria = categoria.id
    JOIN examenes_usuarios ON examenes_usuarios.examen = examenes.id
    WHERE examenes_usuarios.usuario = '$userEmail'
    ORDER BY categoria.id, examenes.id
    LIMIT $offset, $recordsPerPage";

$result = mysqli_query($conn, $query);

// Inicializar una variable para realizar un seguimiento de la categoría actual
$currentCategory = "";

// Iterar sobre el conjunto de resultados
while ($row = mysqli_fetch_assoc($result)) {
    $category = $row['nombreCategoria'];
    $examTitle = $row['titulo'];
    $username = $row['usuario'];
    $grade = $row['nota'];

    // Si la categoría cambia, comenzar un nuevo bloque de categoría
    if ($currentCategory != $category) {
        if ($currentCategory != "") {
            echo '</ul></div>';
        }

        echo '<div><h2>' . $category . '</h2><ul>';
        $currentCategory = $category;
    }

    // Mostrar el resultado del examen
    echo '<li>Nombre del examen: ' . $examTitle . '</li>';
    echo '<li>Asignatura: ' . $category . '</li>';
    echo '<li>Usuario: ' . $username . '</li>';
    echo '<li>Nota: ' . $grade . '</li>';
    echo '</br>';
}

// Cerrar el último bloque de categoría
if ($currentCategory != "") {
    echo '</ul></div>';
}

// Mostrar los enlaces de paginación
echo '<div class="pagination">';
if ($totalPages > 1) {
    echo '<ul>';

    // Enlace a la página anterior
    if ($currentPage > 1) {
        $prevPage = $currentPage - 1;
        echo '<li><a href="?page=' . $prevPage . '">Anterior</a></li>';
    }

    // Enlaces a las páginas
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $currentPage) {
            echo '<li class="active"><a href="?page=' . $i . '">' . $i . '</a></li>';
        } else {
            echo '<li><a href="?page=' . $i . '">' . $i . '</a></li>';
        }
    }

    // Enlace a la página siguiente
    if ($currentPage < $totalPages) {
        $nextPage = $currentPage + 1;
        echo '<li><a href="?page=' . $nextPage . '">Siguiente</a></li>';
    }

    echo '</ul>';
}
echo '</div>';

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>

    </p>
  </div>
</body>
</html>
