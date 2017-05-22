<?php

require '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_REQUEST["id_usuario"]) && isset($_REQUEST["nombre"])){
        
        /*nombre, vida, mana, destreza, percepcion, fuerza, carisma, constitucion, inteligencia, sabiduria*/
        $datosNuevoPersonaje = array(
            'id_estilo' => $_REQUEST["id_estilo"],
            'nombre' => $_REQUEST["nombre"],
            'vida' => isset($_REQUEST["vida"])?($_REQUEST["vida"]):'',
            'mana' => isset($_REQUEST["mana"])?($_REQUEST["mana"]):'',
            'destreza' => isset($_REQUEST["destreza"])?($_REQUEST["destreza"]):'',
            'percepcion' => isset($_REQUEST["percepcion"])?($_REQUEST["percepcion"]):'',
            'fuerza' => isset($_REQUEST["fuerza"])?($_REQUEST["fuerza"]):'',
            'carisma' => isset($_REQUEST["carisma"])?($_REQUEST["carisma"]):'',
            'constitucion' => isset($_REQUEST["constitucion"])?($_REQUEST["constitucion"]):'',
            'inteligencia' => isset($_REQUEST["inteligencia"])?($_REQUEST["inteligencia"]):'',
            'sabiduria' => isset($_REQUEST["sabiduria"])?($_REQUEST["sabiduria"]):''
        );
        
        Connexio::queryInsertNuevoPersonaje($_REQUEST["id_usuario"], $datosNuevoPersonaje);
        
    }else{
        print json_encode(array('estado' => '2', 'mensaje' => 'Faltan Datos.'));
    }
}

?>
