<?php 

require_once("../config/database.php");
require_once("clientesFunciones.php");

$datos = [];

if( isset($_POST['action'])){
    $action = $_POST['action'];
    $db = new Database();
    $con = $db -> conectar();

    if($action == 'existeUsuario'){
        $datos['ok']= usuarioExistente($_POST['usuario'], $con);
    }
    else if($action == 'existeEmail'){
        $datos['ok']= emailExistente($_POST['email'], $con);
    }
}

echo json_encode($datos);