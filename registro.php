<?php
    require("config/config.php");    
    require("config/database.php");
    require("clases/clientesFunciones.php");
    $db = new Database();
    $con = $db->conectar();

    $errors = [];

    if(!empty($_POST)){
        $nombres = trim($_POST['nombres']);
        $apellidos = trim($_POST['apellidos']);
        $email = trim($_POST['email']);
        $usuario = trim($_POST['usuario']);
        $password = trim($_POST['password']);
        $repassword = trim($_POST['repassword']);

        if(esNulo([$nombres, $apellidos, $email, $usuario, $password, $repassword])){
            $errors[] = "Debe llenar todos los campos";
        }

        if(!esEmail($email)){
            $errors[]= "La direccion de correo electronico no es valida";
        }

        if(!validaPassword($password, $repassword)){
            $errors[] = "Las contraseñas no coinciden";
        }

        if(usuarioExistente($usuario, $con)){
            $errors[] = "El nombre de usuario ".$usuario." ya existe";
        }

        if(emailExistente($email, $con)){
            $errors[] = "El correo electronico ".$usuario." ya existe";
        }

        if(count($errors) == 0){
            $id = registrarCliente([$nombres, $apellidos, $email], $con);
            
            if($id >0 ){
                $pass_hash = password_hash($password, PASSWORD_DEFAULT);
                $token = generarToken();
                if(!registrarUsuario([$usuario, $pass_hash, $token, $id], $con)){
                    
                    $errors[] = "Error al registrar al usuario";
                }
            }
            else{
                $errors[] = "Error al registrar al cliente";
            }
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
    <a href="/">
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
    <section>
        <?php mostrarMensajes($errors); ?>
        <form action="registro.php" method="post" autocomplete="off">
            <h1>Crear Cuenta</h1>
            <input type="text" name="nombres" placeholder="Nombre">
            <input type="text" name="apellidos" placeholder="Apellidos">
            <input type="email" name="email" id="email" placeholder="Correo Electronico">
            <span id="validaEmail" style="color: red"></span>
            <input type="text" name="usuario" id="usuario" placeholder="Usuario">
            <span id="validaUsuario" style="color: red"></span>
            <input type="password" name="password" placeholder="Contraseña">
            <input type="password" name="repassword" placeholder="Repetir Contraseña">
            <input type="submit" name="register">
        </form>
    </section>
    <script>
        function ocultarMensajes(){
            let mensajes = document.getElementById("errors");
            mensajes.classList.add('ocultarMensajes');
        }
        let txtUsuario = document.getElementById("usuario");
        txtUsuario.addEventListener("blur", function(){
            existeUsuario(txtUsuario.value);
        }, false);

        let txtEmail = document.getElementById("email");
        txtEmail.addEventListener("blur", function(){
            existeEmail(txtEmail.value);
        }, false);

        function existeEmail(email){
            let URL = 'clases/clienteAjax.php';
            let formData = new FormData();

            formData.append("action", "existeEmail");
            formData.append("email", email);

            fetch(URL,{
                method: 'POST',
                body: formData,
            }).then(response => response.json())
            .then(data =>{
                if(data.ok){
                    document.getElementById("email").value = "";
                    document.getElementById("validaEmail").innerHTML = "Email no disponible";
                }
                else{
                    document.getElementById("validaEmail").innerHTML = "";
                }
            })
        }

        function existeUsuario(usuario){
            let URL = 'clases/clienteAjax.php';
            let formData = new FormData();

            formData.append("action", "existeUsuario");
            formData.append("usuario", usuario);

            fetch(URL,{
                method: 'POST',
                body: formData,
            }).then(response => response.json())
            .then(data =>{
                if(data.ok){
                    document.getElementById("usuario").value = "";
                    document.getElementById("validaUsuario").innerHTML = "Usuario no disponible";
                }
                else{
                    document.getElementById("validaUsuario").innerHTML = "";
                }
            })
        }
    </script>
</body>
</html>