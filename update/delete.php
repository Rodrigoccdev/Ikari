<?php
if(isset($_GET['id'])){
    require("../config/config.php");    
    require("../config/database.php");
    $db = new Database();
    $con = $db->conectar();
    $id = $_GET['id'] ? $_GET['id'] : "";

    $idAlt = intval($id) - 1;

    $dirname = "../images/productos/".$id."/";
    
    if (is_dir($dirname))
        $dir_handle = opendir($dirname);
    while($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            //si no es un directorio elemino el fichero con unlink()
            if (!is_dir($dirname."/".$file))
                unlink($dirname."/".$file);
        }
    }
    closedir($dir_handle);
     //elimino el directorio que ya he vaciado
    rmdir($dirname);

    
    $sql = $con->prepare("DELETE FROM productos WHERE id LIKE ?");
    $sql ->execute([$id]);
    
    $sqlId = $con->prepare("ALTER TABLE productos AUTO_INCREMENT = $idAlt");
    $sqlId ->execute();

    echo "<script language='JavaScript'>
            alert('Articulo Eliminado Exitosamente!');
            location.assign('../update/');
        </script>";
}else{
    header("Location: ../update/");
}