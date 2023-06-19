<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POODLE</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

 
  <?php require './navbar.php'; ?>


  <div class="content">
    <p>
      <?php if (isset($_SESSION['correo'])) {
        echo '<h1>Buenos dias!</h1>';
        echo '<h3>Usa el navegador para consultar examenes o notas</h3>';
      }else {
        echo '<h1>Bienvenidos a Poodle!</h1>';
        echo '<h3>Por favor haga login o registrese para tomar tests</h3>';
      }
      ?>
   
      
    </p>
  </div>


</body>
</html>

