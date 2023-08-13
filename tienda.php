<?php
    require("config/config.php");    
    require("config/database.php");
    $db = new Database();
    $con = $db->conectar();

    $sql = $con->prepare("SELECT id,nombre,precio,descuento, imagen FROM productos WHERE activo=1");
    $sql->execute();
    $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>
<body>
    <?php include("menu.php") ?>
 
    <section class="container">
        <?php foreach($resultado as $row){
            $precio = $row['precio'];
            $descuento = $row['descuento'];
            $precio_desc = $precio - ($precio * $descuento /100); 
            $id = $row['id'];
            $archivo = $row['imagen'];
            $image = "images/productos/$id/$archivo";
        ?>
        <div class="box">
            <a href="detalles.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN);?>">
                <img src="<?php echo  $image; ?>" alt="producto" height="200px">
            </a>
            <h2><?php echo $row['nombre'] ?></h2>
            <?php if($descuento > 0){ ?>
                <p><?php echo moneda . number_format($precio_desc,2,'.',',') ?> <?php echo $descuento ?>% descuento</p>
                <p class="pDesc"><?php echo moneda . number_format($precio,2,'.',',') ?></p>
            <?php }else{ ?>
            <p><?php echo moneda . number_format($precio_desc,2,'.',',') ?></p>
            <?php } ?>
            <button class="btn" onclick="addCarrito(<?php echo $row['id']; ?>,'<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>')">Agregar</button>
        </div>
        <?php } ?>
    </section>
    <script src="carrito.js"></script>
</body>
</html>