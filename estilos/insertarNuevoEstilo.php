<?php

require '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_REQUEST["id_usuario"]) && isset($_REQUEST["nombre"])){
        
        /*nombre, vida, mana, destreza, percepcion, fuerza, carisma, constitucion, inteligencia, sabiduria*/
        $datosNuevoPersonaje = array(
            'nombre' => $_REQUEST["nombre"],
            'vida' => isset($_REQUEST["vida"])?($_REQUEST["vida"]):'N',
            'mana' => isset($_REQUEST["mana"])?($_REQUEST["mana"]):'N',
            'destreza' => isset($_REQUEST["destreza"])?($_REQUEST["destreza"]):'N',
            'percepcion' => isset($_REQUEST["percepcion"])?($_REQUEST["percepcion"]):'N',
            'fuerza' => isset($_REQUEST["fuerza"])?($_REQUEST["fuerza"]):'N',
            'carisma' => isset($_REQUEST["carisma"])?($_REQUEST["carisma"]):'N',
            'constitucion' => isset($_REQUEST["constitucion"])?($_REQUEST["constitucion"]):'N',
            'inteligencia' => isset($_REQUEST["inteligencia"])?($_REQUEST["inteligencia"]):'N',
            'sabiduria' => isset($_REQUEST["sabiduria"])?($_REQUEST["sabiduria"]):'N'
        );
        
        Connexio::queryInsertNuevoEstilo($_REQUEST["id_usuario"], $datosNuevoPersonaje);
        
    }else{
        print json_encode(array('estado' => '2', 'mensaje' => 'Faltan Datos.'));
    }
}

?>