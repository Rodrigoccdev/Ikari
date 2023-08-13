<!DOCTYPE html>
<?php 
    require("config/config.php");    
    require("config/database.php");

    $db = new Database();
    $con = $db ->conectar();
    $id_cliente = $_SESSION['user_cliente'];

    print_r($_SESSION);

    $sql = $con ->prepare("SELECT fecha FROM detalle_compra WHERE id_cliente = ? ORDER BY fecha DESC");
    $sql ->execute([$id_cliente]);
    /*
    $resultado = $sql->fetch(PDO::FETCH_ASSOC);
    $fecha = $resultado['fecha'];

    $sqlDetalle = $con ->prepare("SELECT nombre, precio, cantidad FROM detalle_compra WHERE fecha = ?");
    $sqlDetalle ->execute([$fecha]);*/


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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>
<body>
    <?php if(isset($_SESSION['user_id'])){ ?>
    <a href="/ikari/"><header>
        <p>Entrega a todo AGUASCALIENTES</p>
    </header></a>
    
    <?php include("menu.php") ?>

    <section class="container">
        <?php
            while($row = $sql ->fetch(PDO::FETCH_ASSOC)){
        ?>
        <div class="box">
            <p>Fecha: <?php echo $row['fecha'] ?></p>
        </div>
        <?php } ?>
    </section>
    <?php }else{
        header("Location: index.php"); 
        }?>
</body>
</html>