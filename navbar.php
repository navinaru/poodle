<div class="navbar">
  <div>
    <a class="active" href="./default.php">Inicio</a>
    
    <?php
    session_start();
    if (isset($_SESSION['tipoUsuario'])) {
      $tipoUsuario = $_SESSION['tipoUsuario'];
      
      
      if ($tipoUsuario == 1) {
        echo '<a href="./cursos.php">Cursos</a>';
        echo '<a href="./checknota.php">Notas</a>';
        echo '<a href="./logout.php">Logout</a>';
      } elseif ($tipoUsuario == 2) {
        echo '<a href="./checknotaprofe.php">Notas</a>';
        echo '<a href="./gestion_examenes.php">Crear</a>';
        echo '<a href="./logout.php">Logout</a>';
      } elseif ($tipoUsuario == 3) {
        echo '<a href="./admin_users.php">usuarios</a>';
        echo '<a href="./gestion_examenes.php">Crear</a>';
        echo '<a href="./crear_gestion.php">Gestion</a>';
        echo '<a href="./logout.php">Logout</a>';
      }
      

      
      
    }
    
    ?>

  </div>

  <div class="navbar-right">
    <div class="logo">POODLE</div>

    <?php
    if (isset($_SESSION['tipoUsuario'])) {
      if (isset($_SESSION['nombre']) && isset($_SESSION['apellidos'])) {
        $nombre = $_SESSION['nombre'];
        $apellidos = $_SESSION['apellidos'];
        echo '<div class="template-name">Hola: ' . $nombre . ' ' . $apellidos . '</div>';
      }
    } else {
      echo '<a href="login.php" class="template-name">Login</a>';
    }
    ?>

  </div>
</div>
