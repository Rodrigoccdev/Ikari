<?php

//require_once("config/database.php");

// Comprobar si se ha cargado un archivo
if (isset($_FILES['archivo'])) {
    extract($_POST);
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $descuento = $_POST['descuento'];
    $categoria = $_POST['categoria'];
    $activo = $_POST['activo'];
    $conexion = mysqli_connect("localhost", "root", "", "tienda_online");

    // Definir la carpeta de destino
    

    // Obtener el nombre y la extensión del archivo
    $nombre_archivo = basename($_FILES["archivo"]["name"]);
    $extension = strtolower(pathinfo($nombre_archivo, PATHINFO_EXTENSION));

    // Validar la extensión del archivo
    if ($extension == "jpg" || $extension == "jpeg" || $extension = "png") {


        // Mover el archivo a la carpeta de destino

        // Insertar la información del archivo en la base de datos
        $sql = "INSERT INTO productos(nombre, descripcion, precio, descuento, id_categoria, activo, imagen) 
        VALUES ('$nombre', '$descripcion', '$precio', '$descuento', '$categoria', '$activo', '$nombre_archivo')";
        $resultado = mysqli_query($conexion, $sql);

        if ($resultado) {

            $sql2 = "SELECT id FROM productos WHERE nombre = '$nombre'";
            $resultado2 = mysqli_query($conexion, $sql2);
            $fila = mysqli_fetch_assoc($resultado2);

            $my_dir = "../images/productos/".$fila['id']."/";

            if(!is_dir($my_dir)){
                mkdir($my_dir);
                $carpeta_destino = "../images/productos/".$fila['id']."/";
                if(move_uploaded_file($_FILES["archivo"]["tmp_name"], $carpeta_destino . $nombre_archivo)){
                    echo "<script language='JavaScript'>
                    alert('Archivo Subido');
                    location.assign('../update/');
                    </script>";
                }else{
                    echo "<script language='JavaScript'>
                    alert('Error al subir la imagen: ');
                    location.assign('../update/');
                    </script>";
                }
            }else{
                echo "<script language='JavaScript'>
                alert('Error al agregar el archivo (directorio existente): ');
                location.assign('../update/');
                </script>";
            }
        } else {
            echo "<script language='JavaScript'>
            alert('Error al registrar el producto: ');
            location.assign('../update/');
            </script>";
        }
    } else {
        echo "<script language='JavaScript'>
        alert('Solo se permiten archivos PDF, DOC y DOCX.');
        location.assign('../update/');
        </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Articulo</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/form.css">
</head>
<body>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <h1>Agregar Producto</h1>
        <div>
            <label for="nombre">Nombre</label>
            <input type="tex" name="nombre" placeholder="Nombre">
        </div>
        <br>
        <div>
            <label for="nombre">Descripcion</label>
            <input type="text" name="descripcion" placeholder="Descripcion">
        </div>
        <br>
        <div>
            <label for="nombre">Precio</label>
            <input type="number" name="precio" placeholder="Precio">
        </div>
        <br>
        <div>
            <label for="nombre">Descuento</label>
            <input type="number" name="descuento" placeholder="Descuento">
        </div>
        <br>
        <div>
            <label for="nombre">Categoria</label>
            <input type="number" name="categoria" placeholder="Categoria">
        </div>
        <br>
        <div>
        <div>
            <label for="nombre">Activo</label>
            <select name="activo">
              <option value="0" selected>0</option>
              <option value="1">1</option>
            </select>
        </div>
        <br>
        <div>
            <label for="archivo">Imagen de Producto</label>
            <input type="file" name="archivo" id="archivo" class="form-control" required>
        </div>
        <div>
            <input type="submit" name="register">
        </div>
    </form>
</body>
</html>