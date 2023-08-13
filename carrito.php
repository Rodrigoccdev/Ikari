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
</head>
<body>
    
    <?php include("menu.php") ?>

    <section class="container">
        <div class="dt">
            <table class="ctable">
                <tbody>
                    <?php if($lista_carrito == null){
                        echo '<tr><td><b>Su carrito esta vacio</b></td></tr><br>
                            <tr><td><a href="/ikari/tienda.php"><button class="btn">Regresar a tienda</button></a></td></tr>';
                    }else{?>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>subtotal</th>
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
                        <td><?php echo moneda . number_format($precio_desc,2,'.',',') ?></td>
                        <td>
                            <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad ?>" size="5" id="cantidad_<?php echo $_id ?>" onchange="actualizarCantidad(this.value, <?php  echo $_id ?>)">
                        </td>
                        <td>
                            <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo moneda . number_format($subtotal,2,'.',',') ?></div>
                        </td>
                        <td><a href="#" id="eliminar" class="btn" data-bs-id="<?php echo $_id; ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal" onclick="openPopup()">Eliminar</a></td>
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
        </div>
    </section>
    <section class="container">
        <div></div>
        <div></div>
        <?php if(isset($_SESSION['user_cliente'])){ ?>
        <div class="pago">
            <a href="pago.php"><button class="btnP">Realizar Pago</button></a>
        </div>
        <?php }else{ ?>
        <div class="pago">
            <a href="login.php?pago"><button class="btnP">Realizar Pago</button></a>
        </div>
        <?php } ?>
    </section>
    <?php } ?>

    <!-- Modal -->
    <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-footer">
            <button id="btn-elimina" type="button" class="btn btn-danger" onclick="eliminarArticulo()">Save changes</button>
        </div>
        </div>
    </div>
    </div>
    <!-- Modal -->
    <div class="popup" id="popup">
        <h2>¿Desea eliminar el articulo?</h2>
        <button class="cancel" onclick="closePopup()">Cancelar</button>
        <button class="eliminar" id="eliminar" onclick="eliminarArticulo()">Eliminar</button>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        let eliminaModal = document.getElementById("eliminaModal");
        eliminaModal.addEventListener('show.bs.modal', function(event){
            let popup = document.getElementById("popup");
            let button = event.relatedTarget;
            let id = button.getAttribute('data-bs-id');
            let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina');
            let buttonEliminar = popup.querySelector('#eliminar');
            buttonElimina.value = id;
            buttonEliminar.value = id;
        })

        function eliminarArticulo(){

            let btnElimina = document.getElementById("btn-elimina");
            let id = btnElimina.value;

            let url = '/ikari/clases/actualizar_carrito.php';
            let formData = new FormData();
            formData.append('id', id);
            formData.append('action', 'eliminar');

            fetch(url,{
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
            .then(data=>{
                if(data.ok){
                    location.reload();
                }
            })
        }
    </script>
    <script>
        let popup = document.getElementById("popup");

        function openPopup(){
            popup.classList.add('open-popup');
        }
        function closePopup(){
            popup.classList.remove('open-popup');
        }
    </script>
    <script>
        function actualizarCantidad(cantidad,id){
            let url = '/ikari/clases/actualizar_carrito.php';
            let formData = new FormData();
            formData.append('id', id);
            formData.append('cantidad', cantidad);
            formData.append('action', 'agregar');

            fetch(url,{
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
            .then(data=>{
                if(data.ok){
                    let subtotal = document.getElementById("subtotal_" + id);
                    subtotal.innerHTML = data.sub;

                    let total = 0.00;
                    let lista = document.getElementsByName("subtotal[]");

                    for(let i=0; i < lista.length; i++){
                        total += parseFloat(lista[i].innerHTML.replace(/[$,]/g, ''))
                    }

                    total = new Intl.NumberFormat('en-US',{
                        minimumFractionDigits: 2
                    }).format(total);

                    document.getElementById('total').innerHTML = '<?php echo moneda ?>' + total;
                }
            })
        }
    </script>
</body>
</html>