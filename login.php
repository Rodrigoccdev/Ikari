<?php
    require("config/config.php");    
    require("config/database.php");
    require("clases/clientesFunciones.php");
    $db = new Database();
    $con = $db->conectar();

    $proceso = isset($_GET['pago']) ? 'pago' : 'login';

    $errors = [];

    if(!empty($_POST)){
        $usuario = trim($_POST['usuario']);
        $password = trim($_POST['password']);
        $proceso = $_POST['proceso'] ?? 'login';

        if(esNulo([$usuario, $password])){
            $errors[] = "Debe llenar todos los campos";
        }
        if(count($errors) == 0){
            $errors[] = login($usuario, $password, $con, $proceso);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Ikari</title>
    <link rel="icon" href=<?php echo Icon; ?>>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/tienda.css">
    <link rel="stylesheet" href="style/form.css">
    <link rel="stylesheet" href="style/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>
<body>
    <a href="/}">
        <header><p>Entrega a todo AGUASCALIENTES</p></header>
    </a>
    <nav>
        <input type="checkbox" name="" id="check">
        <label for="check" class="checkbtn">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b2/Hamburger_icon.svg/2048px-Hamburger_icon.svg.png" alt="" class="menu" height="50px">
        </label>
        <a href="/" class="enlace">
            <img src="images/logoIkari.jpg" height="50px">
        </a>
        <a href="/carrito" class="menu">
            <img src="https://cdn-icons-png.flaticon.com/512/107/107831.png" alt="" height="30px">
            <span id="num_cart" class=""><?php echo $num_cart ?></span>
        </a>
        <ul class="list">
            <li id="x" class="op"><a href=""><label for="check">X</label></a></li>
            <li class="op"><a href="/">Home</a></li>
            <li class="op"><a href="/">Informacion</a></li>
            <li class="op"><a href="/tienda">Camisas</a></li>
            <li class="op"><a href="/">Contacto</a></li>
        </ul>
    </nav>
    <?php mostrarMensajes($errors) ?>
    <form action="login.php" method="post" autocomplete="off">
        <input type="hidden" name="proceso" value="<?php echo $proceso; ?>">
        <h1>Iniciar Sesion</h1>
        <input type="text" name="usuario" placeholder="Usuario">
        <input type="password" name="password" placeholder="Contraseña">
        <input type="submit" name="login">
        <br><br>
        <hr>
        <br>
        <p>¿No tienes cuenta? <a href="/registro">Registrate aqui</a></p>
    </form>
    <script>
        function ocultarMensajes(){
            let mensajes = document.getElementById("errors");
            mensajes.classList.add('ocultarMensajes');
        }
    </script>
</body>
</html>