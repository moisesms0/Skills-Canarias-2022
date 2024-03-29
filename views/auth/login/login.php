<!DOCTYPE html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.0.2 -->

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="css/login.css" />
  <link rel="shortcut icon" href="/Skills-Canarias-2022/favicon.ico" type="image/x-icon">
</head>

<body class="bg-login  vh-100 d-flex">
  <div class="container shadow animation redondeado-start align-self-sm-center">

    <div class="redondeado-start  row">

      <div class="d-none d-lg-block col-7 p-0 h-100 ">
        <div class="fondoLogin position-relative">
        <a href="../../../index.php" class="position-absolute m-4 text-white d-flex align-items-cente"><i class='bx bx-left-arrow-alt pt-1' style='color:#ffffff'  ></i>Volver</a>
        </div>
      </div>

      <div class="col-12 col-lg-5 py-4 redondeado-end bg-light position-relative d-flex align-items-center ">
        <div class="w-100">
        <form class="w-100" action="" method="post" id="login">
          <h2 class="text-center pt-4 fw-light bienvenido">Bienvenido</h3>
            <h4 class="text-center fs-5 fw-light">Inicia sesión con tu cuenta</h4>
            <div class="email form-floating mb-3 mx-5 mt-4">

              <input type="email" class="form-control formulario" id="mail" name="mail" placeholder="name@example.com">
              <label for="mail">Dirección de Correo Electrónico</label>

            </div>
            <div class="pass form-floating mb-3 mx-5 mt-4">

              <input type="password" class="form-control formulario" id="pass" name="pass" placeholder="Password">
              <label for="pass">Contraseña</label>

              <p class="pt-3 text-end "><a href="#">¿Olvidaste tu contraseña?</a></p>

            </div>
        </form>

            <div class="text-center mb-3 px-5 mt-4">
              <input class="loginButon" onclick="validation()" type="submit" value="Iniciar Sesión" />
            </div>

            <div class="text-center mb-3 px-5 mt-4">
              <p><a href="../register/register.php">Crea tu cuenta.</a></p>
            </div>

            <!--
            <div class="text-center">
              Tambien puedes iniciar sesión con:
            </div>

            <div class="d-flex justify-content-center h-auto mt-3 pb-4">
              <a href=""><img class="mx-2" src="img/google.png" alt="" width="45px"></a>
              <a href=""> <img class="mx-2" src="img/facebook.png" alt="" width="45px"></a>
              <a href=""><img class="mx-2" src="img/twitter.png" alt="" width="45px"></a>

            </div> 
            -->


            <div>

            </div>

          </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
  </script>
  <script src="../../../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
  <script src="js/validations.js"></script>

  <?php

if (isset($_POST['mail'])){
  include_once '../../../config/config.php';

# ===========================================
# ---------------- Variables ----------------
# ===========================================

function limpiar($input) {
 
  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Elimina javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Elimina las etiquetas HTML
    '@<style[^>]*?>.*?</style>@siU',    // Elimina las etiquetas de estilo
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Elimina los comentarios multi-línea
  );
 
    $output = preg_replace($search, '', $input);
    return $output;
  }

  $mail = limpiar($_POST['mail']);
  $pass = limpiar($_POST['pass']);

# ==================================================
# ---------------- Exist validation ----------------
# ==================================================
    $exist= 0;

    $sql = "SELECT * FROM usuarios WHERE mail = '$mail'";
    $result = mysqli_query($connect, $sql);
    while ($row = mysqli_fetch_array($result)) {
      $usuario = $row['user'];
      $admin = $row['permisos'];
      $hash = $row['pass'];
      $exist++;
    }

    if ($exist == 0) {
      echo "<script>const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 0,
        timerProgressBar: true,
        didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
    
    Toast.fire({
        icon: 'error',
        title: 'El usuario no existe'

    })</script>";
    }






# ========================================
# ---------------- Insert ----------------
# ========================================

    else{

      if (password_verify($pass, $hash)){  # Verifica si la contraseña es correcta
        session_start();
        $_SESSION['user'] = $usuario;
        $_SESSION['admin'] = $admin;
        header("Location: ../../../index.php");
    }else{
      echo "<script>const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 0,
        timerProgressBar: true,
        didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
    
    Toast.fire({
        icon: 'error',
        title: 'El usuario o la contraseña son incorrectos'

    })</script>";
    }
    
}
}

?>


</body>

</html>