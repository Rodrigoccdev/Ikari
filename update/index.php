<?php
require("../config/config.php");    
require("../config/database.php");
$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT id, nombre, descripcion, precio, descuento, id_categoria, activo, imagen FROM productos");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articulos</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</head>
<body>
    <br>
    <div class="container">
        <h1 style="text-align: center;">Articulos en tienda</h1>
        <br>
        <div class="col-sm-12">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Precio</th>
                        <th>Descuento</th>
                        <th>id_Categoria</th>
                        <th>Activo</th>
                        <th>Imagen</th>
                    </tr>
                </thead>
                <tbody>
                   <?php
                    foreach($resultado as $row){
                        $archivo = $row['imagen'];
                        $id = $row['id'];
                        $image = "../images/productos/$id/$archivo";
                   ?>
                    <tr>
                        <td><?php echo $row['id'] ;?></td>
                        <td><?php echo $row['nombre'] ;?></td>
                        <td><?php echo $row['descripcion'] ;?></td>
                        <td><?php echo $row['precio'] ;?></td>
                        <td><?php echo $row['descuento'] ;?></td>
                        <td><?php echo $row['id_categoria'] ;?></td>
                        <td><?php echo $row['activo'] ;?></td>
                        <td><img src="<?php echo $image; ?>" alt="Producto" height="50px"></td>
                        <td><a href="edit?id=<?php echo $row['id'] ?>" type="button" class="btn btn-warning">Editar</a></td>
                        <td><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminar" data-bs-id="<?php echo $row['id'];?>">Eliminar</button></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div>
            <a href="upload" type="button" class="btn btn-success">Agregar</a>
        </div>
    </div>
    <?php include("eliminar.php")?>
    <script>
        let elimaModal = document.getElementById("eliminar");
        elimaModal.addEventListener('show.bs.modal', function(event){
            let button = event.relatedTarget;
            let id = button.getAttribute('data-bs-id');
            let buttonElimina = elimaModal.querySelector('.modal-footer #btn-elimina');
            buttonElimina.value = id;
        })

        function eliminar(){
            let botonEliminar = document.getElementById('btn-elimina');
            let id = botonEliminar.value;

            location.assign("delete?id=" + id);
        }
    </script>
</body>
</html>