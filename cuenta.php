<!DOCTYPE html>
<?php 
    require("config/config.php");    
    require("config/database.php");
?>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>
<body>
    <?php if(isset($_SESSION['user_id'])){ ?>
    <a href="/">
        <header><p>Entrega a todo AGUASCALIENTES</p></header>
    </a>
    <nav>
        <input type="checkbox" name="" id="check">
        <label for="check" class="checkbtn">
            <img src="https://img.uxwing.com/wp-content/themes/uxwing/download/web-app-development/hamburger-menu-icon.png" alt="" class="menu" height="50px">
        </label>
        <a href="/" class="enlace">
            <img src="images/logoIkari.jpg" height="50px">
        </a>
        <a href="/carrito" class="menu">
            <img src="https://cdn-icons-png.flaticon.com/512/107/107831.png" alt="" height="30px">
            <span id="num_cart" class=""><?php echo $num_cart ?></span>
        </a>
        <?php if(isset($_SESSION['user_name'])){ ?>
            <a href="/cuenta" class="menu" style="padding:5px; text-align: center">
                <img src="https://img.freepik.com/free-icon/user_318-286823.jpg" alt="" height="30px">
                <p><?php echo $_SESSION['user_name'] ?></p>
            </a>
            <?php }else{ ?>
            <a href="/login" class="menu" style="text-align: center;">
                <img src="https://img.freepik.com/free-icon/user_318-286823.jpg" alt="" height="30px">
            </a>
        <?php } ?>
        <ul class="list">
            <li id="x" class="op"><a href=""><label for="check">X</label></a></li>
            <li class="op"><a href="/">Home</a></li>
            <li class="op"><a href="/">Informacion</a></li>
            <li class="op"><a href="/tienda">Camisas</a></li>
            <li class="op"><a href="/">Contacto</a></li>
        </ul>
    </nav>
    <section class="cuenta">
        <a href="logout.php" class="btn">Cerrar Sesion</a>
    </section>
    <?php }else{ 
        header("Location: /");
    }?>
</body>
</html>