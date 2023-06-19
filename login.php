<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <link rel="stylesheet" type="" href="./style.css">
  <style>
    body {
      font-family: Helvetica, Arial, sans-serif;
      background-color: #f2f2f2;
    }

    .container {
      width: 400px;
      margin: 0 auto;
      margin-top: 100px;
      padding: 20px;
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 8px;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
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

    .create-account {
      margin-top: 20px;
      text-align: center;
    }

    .create-account a {
      color: #555;
      text-decoration: none;
    }

    .create-account a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Iniciar sesión</h2>
    <form method="POST" action="">
      <label for="correo">Correo:</label>
      <input type="text" id="correo" name="correo" placeholder="Ingrese su correo" required>

      <label for="password">Contraseña:</label>
      <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required>

      <input type="submit" value="Iniciar sesión">
      <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $correo = $_POST['correo'];
          $password = $_POST['password'];

          require "./conn.php";
          $conn = getconn();

          // sanitizar campos injección sql
          $correo = mysqli_real_escape_string($conn, $correo);
          $password = mysqli_real_escape_string($conn, $password);

          // traer los datos de usuario de la base para comparar
          $sql = "SELECT correo, nombre, apellidos, tipoUsuario, grupo FROM Usuarios WHERE correo = '$correo' AND password = '$password'";
          $result = mysqli_query($conn, $sql);

          if (mysqli_num_rows($result) == 1) {
            // if correcto empezar y almacenar sesion
            session_start();
            $row = mysqli_fetch_assoc($result);

            $_SESSION['correo'] = $row['correo'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['apellidos'] = $row['apellidos'];
            $_SESSION['tipoUsuario'] = $row['tipoUsuario'];
            $_SESSION['grupo'] = $row['grupo'];

           
            header("Location: default.php");
            exit();
          } else {
            echo '<p class="error">Correo o contraseña incorrectos.</p>';
          }

          
          mysqli_close($conn);
        }
      ?>
    </form>
    <div class="create-account">
      ¿No tienes una cuenta? <a href="./registrar.php">Crear cuenta</a>
    </div>
  </div>
</body>
</html>
