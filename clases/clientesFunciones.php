<?php 

function esNulo( array $parametros){
    foreach($parametros as $parametro){
        if(strlen(trim($parametro)) < 1){
            return true;
        }
    }
    return false;
}

function esEmail($email){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }
    return false;
}

function validaPassword($password, $repassword){
    if(strcmp($password, $repassword) === 0){
        return true;
    }
    return false;
}

function generarToken(){
    return md5(uniqid(mt_rand(),false));
}

function usuarioExistente($usuario, $con){
    $sql = $con ->prepare("SELECT id FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    if($sql->fetchColumn() > 0){
        return true;
    }
    return false;
}

function emailExistente($email, $con){
    $sql = $con ->prepare("SELECT id FROM clientes WHERE email LIKE ? LIMIT 1");
    $sql->execute([$email]);
    if($sql->fetchColumn() > 0){
        return true;
    }
    return false;
}

function registrarCliente(array $datos, $con){
    $sql = $con ->prepare("INSERT INTO clientes (nombre, apellidos, email, estatus, fecha_alta) VALUES (?,?,?,1,now())");
    if($sql->execute($datos)){
        return $con-> lastInsertId();
    }
    return 0;    
}

function registrarUsuario(array $datos, $con){
    $sql = $con ->prepare("INSERT INTO usuarios (usuario, password, token, id_cliente) VALUES (?,?,?,?)");
    if($sql -> execute($datos)){
        return true;
    }
    return false;
}

function mostrarMensajes(array $errors){
    if(count($errors) > 0){
        echo '<div id="errors" style="text-align: center"><ul>';
        foreach($errors as $error){
            echo '<li style="color: red">*' .$error. '</li>';
        }
        echo '</ul>';
        echo '<button onclick="ocultarMensajes()">Cerrar</button></div>';
    }
}

function login($usuario, $password, $con, $proceso){
    $sql = $con -> prepare("SELECT id, usuario, password, id_cliente FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql -> execute([$usuario]);
    
    if($row = $sql -> fetch(PDO::FETCH_ASSOC)){
        if(esActivo($usuario, $con)){
            if(password_verify($password, $row['password'])){
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['usuario'];
                $_SESSION['user_cliente'] = $row['id_cliente'];
                if($proceso == 'pago'){
                    header("Location: carrito.php");
                }
                else{
                    header("Location: index.php");
                }
                exit;
            }
        }
        else{
            return 'El usuario no ha sido activado';
        }
    }
    return 'El usuario y/o contraseña son incorrectos';
}

function esActivo($email, $con){
    $sql = $con -> prepare("SELECT activacion FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql -> execute([$email]);
    $row = $sql ->fetch(PDO::FETCH_ASSOC);

    if($row['activacion'] == 1){
        return true;
    }
    return false;
}