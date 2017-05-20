<?php


$host = "localhost";
$servername = "alcaroldb";
$username = "root";
$password = "";

require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_REQUEST['username']) && !empty($_REQUEST['password'])) {
        $retorno = Connexio::queryLoadUser($_REQUEST['username'], $_REQUEST['password']);
        if ($retorno) {
            print json_encode(array('estado' => '1', 'mensaje' => 'Bienvenido '.$_SESSION['username']
			, 'id_usuario' => $_SESSION['id'],
			'nombre' => $_SESSION['nombre'],
			'dni' => $_SESSION['user_dni']));
        }else{
            print json_encode(array('estado' => '2', 'mensaje' => 'LogIn erroneo.'));
        }
    } else {
        print json_encode(
                        array(
                            'estado' => '2',
                            'mensaje' => 'Faltan Datos para poder Loggear'
                        )
        );
    }
}
?>