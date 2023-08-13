<?php
    require("config/config.php");    
    require("config/database.php");
    $db = new Database();
    $con = $db->conectar();
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $token = isset($_GET['token']) ? $_GET['token'] : '';

    if($id == ' ' || $token == ' '){
        header("Location: tienda.php");
        exit;
    }
    else{
        $token_temp = hash_hmac('sha1', $id, KEY_TOKEN);
        if($token == $token_temp){
            $sql = $con->prepare("SELECT count(id) FROM productos WHERE id=? AND activo=1");
            $sql->execute([$id]);

            if($sql->fetchColumn() > 0){
                $sql = $con->prepare("SELECT nombre,descripcion,precio,descuento FROM productos WHERE id=? AND activo=1 LIMIT 1");
                $sql ->execute([$id]);
                $row = $sql->fetch(PDO::FETCH_ASSOC);

                $nombre = $row['nombre'];
                $descripcion = $row['descripcion'];
                $precio = $row['precio'];
                $descuento = $row['descuento'];
                $precio_desc = $precio - (($precio * $descuento)/100);

                $imagenes_dir = 'images/productos/'.$id.'/';
                $rutaimg = $imagenes_dir . 'principal.jpg';

                $imagenes = array();

                $dir = dir($imagenes_dir);

                while(($archivo = $dir->read()) != false){
                    if($archivo != 'principal.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg'))){
                        $imagenes[] = $imagenes_dir . $archivo;
                    }
                }
                $dir->close();
            } 
        }
        else{
            header("Location: tienda.php");
            exit;
        }
    }
    $sql = $con->prepare("SELECT id,nombre,precio FROM productos WHERE activo=1");
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
    <link rel="stylesheet" href="style/slider.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>
<body>

    <?php include("menu.php") ?>
   
    <section class="container">
        <div class="box">
            <?php if($imagenes == null){?>
                <img src="<?php echo $rutaimg; ?>" alt="" class="img">
                <?php }else{?>
                    <div class="slideshow-container">
                        <div class="mySlides fade">
                            <img src="<?php echo $rutaimg; ?>" alt="" class="img">
                        </div>
                        <?php foreach($imagenes as $img){ ?>
                            <div class="mySlides fade">
                                <img src="<?php echo $img; ?>" alt="" class="img">
                            </div>
                            <a class="prev btn" onclick="plusSlides(-1)">&#10094;</a>
                            <a class="next btn" onclick="plusSlides(1)">&#10095;</a>
                        <?php } ?>
                    </div>
                <?php }?>
        </div>
        <div class="box">
            <h2 class="h2"><?php echo $nombre ?></h2>
            <?php if($descuento > 0 ) {?>
                <p class="p desc"><?php echo moneda . number_format($precio,2,'.',',') ?></p>
                <h2 class="h2">
                    <?php echo moneda . number_format($precio_desc,2,'.',',') ?>
                    <small><?php echo $descuento ?>% descuento</small>
                </h2>
            <?php } else{?>
            <h2 class="h2"><?php echo moneda . number_format($precio,2,'.',',') ?></h2>
            <?php }?>
            <p class="p"><?php echo $descripcion ?></p>
            <div>
                <button class="btnCompra">Comprar ahora</button>
                <button class="btnCompra" onclick="addCarrito(<?php echo $id; ?>,'<?php echo $token_temp; ?>')">Agregar al carrito</button>
            </div>
        </div>
    </section>
    <script src="carrito.js"></script>
    <script>
        var slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n){
            showSlides(slideIndex += n);
        }

        function currentSlides(n){
            showSlides(slideIndex = n);
        }

        function showSlides(n){
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            if(n > slides.length){
                slideIndex = 1;
            }
            if(n < 1){
                slideIndex = slides.length;
            }
            for( i = 0; i < slides.length; i++){
                slides[i].style.display = "none";
            }
            for(i = 0; i < dots.length; i++){
                dots[i].className = dots[i].className.replace("active", "")
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex -1].className += "active";
        }
    </script>
</body>
</html>