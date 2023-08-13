<?php
    require("config/config.php");    
    require("config/database.php");
    $db = new Database();
    $con = $db->conectar();
    $lista_carrito = array();
    $ta_carrito = array();
    $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] :null;

    if($productos != null){
        foreach($productos as $clave => $cantidad){
            $sql = $con->prepare("SELECT id,nombre,precio,descuento, $cantidad AS cantidad FROM productos WHERE id=? AND activo=1");
            $sql->execute([$clave]);
            $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
        }
    }
    else{
        header("Location: tienda.php");
        exit;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="style/modal.css">
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo ClientId; ?>&currency=<?php echo Currency; ?>"></script>
</head>
<body>
    <?php include("menu.php") ?>
   
    <section class="container">
        <div class="box">
            <h3>Detalles de pago</h3>
            <table class="ctable">
                <tbody>
                    <?php if($lista_carrito == null){
                        echo '<tr><td><b>Su carrito esta vacio</b></td></tr><br>
                            <tr><td><a href="/ikari/tienda.php"><button class="btn">Regresar a tienda</button></a></td></tr>';
                    }else{?>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead><?php 
                        $total = 0;
                        foreach($lista_carrito as $producto){
                            $_id = $producto['id'];
                            $nombre = $producto['nombre'];
                            $precio = $producto['precio'];
                            $descuento = $producto['descuento'];
                            $cantidad = $producto['cantidad'];
                            $precio_desc = $precio - (($precio*$descuento)/100);
                            $subtotal = $cantidad * $precio_desc;
                            $total += $subtotal;
                         ?> 
                    <tr>
                        <td><?php echo $nombre ?></td>
                        <td>
                            <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo moneda . number_format($subtotal,2,'.',',') ?></div>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td><b>Total</b></td>
                        <td>
                            <h2 id="total"><?php echo moneda . number_format($total,2,'.',',')?></h2>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php } ?>
        </div>
        <div class="box">
            <h3>Realizar Pago</h3>
            <div class="btnPaypal">
                <div id="paypal-button-container"></div>
            </div>
        </div>
    </section>
    <script>
      paypal.Buttons({
            style:{
                color: 'blue',
                shape: 'pill',
                label: 'pay'
            },
            createOrder: function(data, actions){
                return actions.order.create({
                    purchase_units: [{
                        amount:{
                            value: <?php echo $total ?>
                        }
                    }]
                })
            },
            onApprove: function(data, actions){
                let URL = 'clases/captura.php'
                actions.order.capture().then(function(detalles){
                    console.log(detalles)
                    //window.location.href="gracias.php";
                    return fetch(URL,{
                        method: 'POST',
                        headers: {
                            'content-type':'application/json'
                        },
                        body: JSON.stringify({
                            detalles: detalles
                        })
                    })
                });     
            },
            onCancel: function(data){
                alert("Pago Cancelado");
                console.log(data)
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>