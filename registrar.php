<!DOCTYPE html>
<html>
<head>
  <title>Registratrar</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
    }

    .container {
      width: 300px;
      margin: 0 auto;
      margin-top: 100px;
      padding: 20px;
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    h2 {
      text-align: center;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    input[type="submit"] {
      background-color: black;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      width: 100%;
    }

    input[type="submit"]:hover {
      background-color: #333;
    }

    .error {
      color: red;
      font-size: 14px;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Register</h2>
    <form method="POST" action="">
      <label for="correo">correo:</label>
      <input type="text" id="correo" name="correo" placeholder="Enter your correo" required>

      <label for="password">Contraseña:</label>
      <input type="password" id="password" name="password" placeholder="Enter your password" required>

      <label for="nombre">Nombre:</label>
      <input type="text" id="nombre" name="nombre" placeholder="Enter your name" required>

      <label for="apellidos">Apellidos:</label>
      <input type="text" id="apellidos" name="apellidos" placeholder="Enter your last name" required>

      <input type="submit" value="Register">
      <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $correo = $_POST['correo'];
          $password = $_POST['password'];
          $nombre = $_POST['nombre'];
          $apellidos = $_POST['apellidos'];

          
          require "./conn.php";
          $conn = getconn();

          
          $correo = mysqli_real_escape_string($conn, $correo);
          $password = mysqli_real_escape_string($conn, $password);
          $nombre = mysqli_real_escape_string($conn, $nombre);
          $apellidos = mysqli_real_escape_string($conn, $apellidos);

          
          $sql = "INSERT INTO Usuarios (correo, password, nombre, apellidos) VALUES ('$correo', '$password', '$nombre', '$apellidos')";
          if (mysqli_query($conn, $sql)) {
            echo '<p>Registrado correctamente puedes acceder al  <a href="login.php">login</a>.</p>';
          } else {
            echo '<p class="error">Error</p>';
          }

          
          mysqli_close($conn);
        }
      ?>
    </form>
  </div>
</body>
</html>
