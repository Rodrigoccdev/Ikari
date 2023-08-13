<?php
    require("../config/config.php");    
    require("../config/database.php");
    $db = new Database();
    $con = $db->conectar();

    $sql = $con->prepare("SELECT id,nombre,precio FROM productos WHERE activo=1");
    $sql->execute();
    $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Ikari</title>
    <link rel="icon" href="logoIkari.jpg">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/tienda.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>
<body>
    <a href="/ikari/">
        <header><p>Entrega a todo AGUASCALIENTES</p></header>
    </a>
    <nav>
        <input type="checkbox" name="" id="check">
        <label for="check" class="checkbtn">
            <img src="https://img.uxwing.com/wp-content/themes/uxwing/download/web-app-development/hamburger-menu-icon.png" alt="" class="menu" height="50px">
        </label>
        <a href="/ikari/" class="enlace">
            <img src="logoIkari.jpg" height="50px">
        </a>
        <ul class="list">
            <li id="x" class="op"><a href=""><label for="check">X</label></a></li>
            <li class="op"><a href="/ikari/">Home</a></li>
            <li class="op"><a href="/ikari/">Informacion</a></li>
            <li class="op"><a href="/ikari/tienda.php">Camisas</a></li>
            <li class="op"><a href="/ikari/">Contacto</a></li>
        </ul>
    </nav>    
    <section class="container">
        <?php foreach($resultado as $row){

            $id = $row['id'];
            $image = "images/productos/$id.jpg";
        ?>
        <div class="box">
            <a href="detalles.php?id=<?php echo $row['id']; ?>&token= <?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN);?>">
                <img src="<?php echo  $image ?>" alt="producto">
            </a>
            <h2><?php echo $row['nombre'] ?></h2>
            <p>$<?php echo number_format($row['precio'],2,'.',',') ?></p>
            <button class="btn" onclick="addCarritto()">Agregar</button>
        </div>
        <?php } ?>
    </section>
    <script src="carrito.js"></script>
</body>
</html>