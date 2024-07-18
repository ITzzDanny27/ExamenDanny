<?php

require_once("../models/clase.model.php");

$clase = new Clase();
$metodo = $_SERVER['REQUEST_METHOD'];

switch($_GET["op"]) {

    case "listar":
        $ListaClases = array();
        $dato = $clase->listarClases();
    
        while($fila = mysqli_fetch_assoc($dato)) {
            $ListaClases[] = $fila;
        }
    
        if (!empty($ListaClases)) {
            echo json_encode($ListaClases);
        } else {
            echo json_encode(['message' => 'No hay clases registradas']);
        }
        
    break;

    case "uno":

        if(isset($_GET["id"])){
            $dato = $clase->uno($_GET["id"]);
            if($dato){
                echo json_encode($dato);
            }else{
                echo json_encode(['message' => 'La clase no existe']);
            }
        } else {
            echo json_encode(['message' => 'El ID de la clase es obligatorio']);
        }

    break;
    

    case "insertar":
        
        $nombre_clases = $_POST["Nombre"];
        $descripcion = $_POST["Descripcion"];

        if (!empty($nombre_clases) && !empty($descripcion)) {
            $respuesta = $clase->registrarClase($nombre_clases, $descripcion);
            echo json_encode($respuesta);
        } else {
            echo json_encode(['message' => 'Todos los campos son obligatorios']);
        }

    break;

    case "actualizar":

        $clase_id = $_POST["EditarClaseId"];
        $nombre_clase = $_POST["EditarNombreClase"];
        $descripcion = $_POST["EditarDescripcion"];

        if($clase_id && $nombre_clase && $descripcion){
            $respuesta = $clase->actualizarClase($clase_id, $nombre_clase, $descripcion);
            echo json_encode($respuesta);
        }else{
            echo json_encode(['message' => 'Todos los campos son obligatorios']);
        }

    break;


    case "eliminar":
        $clase_id = $_POST["ClaseId"] ?? null;

        if (!empty($clase_id)) {
            $eliminado = $clase->eliminarClase($clase_id);
            if ($eliminado) {
                echo json_encode("Clase eliminada");
            } else {
                echo json_encode("Error al eliminar clase");
            }
        } else {
            echo json_encode(array("message" => "El ID de la clase es obligatorio"));
        }
    break;

    case "listarClasesCombos":
        $listaClases = array();
        $dato = $clase->listarClasesCombo();

        while($fila = mysqli_fetch_assoc($dato)) {
            $listaClases[] = $fila;
        }

        echo json_encode($listaClases);
    break;

    // case 'listarClasesCombos':
    //     $datos = $clase->listarClasesCombo();
    //     $data = Array();
    //     while ($row = $datos->fetch_assoc()) {
    //         $data[] = array(
    //             "clase_id" => $row["clase_id"],
    //             "nombre_clases" => $row["nombre_clases"],
    //             "descripcion" => $row["descripcion"]
    //         );
    //     }
    //     echo json_encode($data);
    //     break;
}
