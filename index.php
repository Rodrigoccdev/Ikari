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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>
<body>
    <?php include("menu.php") ?>

    <section class="home">
        <div class="slider">
            <ul>
                <li><img src="images/banner.jpg" alt=""></li>
                <li><img src="images/banner2.jpg" alt=""></li>
                <li><img src="images/banner.jpg" alt=""></li>
                <li><img src="images/banner2.jpg" alt=""></li>
            </ul>
        </div>
        <div class="in-flex">
            <div class="title">
                <h1>Ikari</h1>
                <p>Nace desde la idea creada por Rodrigo Carreon y su pasion por el anime y el diseño, uniendo estos dos en un mismo ambiente
                creando <b>Ikari</b></p>
                <p>Una marca de ropa orgullosamente hidrocalida</p>
            </div>
        </div>
    </section>
</body>
</html>