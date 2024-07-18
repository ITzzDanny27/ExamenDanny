<?php

require_once("../models/asignacion.model.php");

$asignacion = new Clase_Asignacion();

switch($_GET["op"]) {

    case "listar":
        $ListaAsignaciones = array();
        $dato = $asignacion->listarAsignaciones();

        while($fila = mysqli_fetch_assoc($dato)) {
            $ListaAsignaciones[] = $fila;
        }

        if (!empty($ListaAsignaciones)) {
            echo json_encode($ListaAsignaciones);
        } else {
            echo json_encode(['message' => 'No hay asignaciones registradas']);
        }
    break;

    case "uno":
        if (isset($_GET["id"])) {
            $dato = $asignacion->uno($_GET["id"]);
            if ($dato) {
                echo json_encode($dato);
            } else {
                echo json_encode(['message' => 'La asignación no existe']);
            }
        }
    break;

    case "insertar":
        $id_profesor = $_POST["Profesores"];
        $id_clase = $_POST["Clases"];
    
        // Depuración: Verifica los valores recibidos
        //var_dump($id_profesor, $id_clase);

        $asignacion->registrarAsignacion($id_profesor, $id_clase);
    
        // if (!empty($id_profesor) && !empty($id_clase)) {
        //     $respuesta = $asignacion->registrarAsignacion($id_profesor, $id_clase);
        //     echo json_encode($respuesta);
        // } else {
        //     echo json_encode(['message' => 'Todos los campos son obligatorios']);
        // }
    break;
    
    

    case "actualizar":
        $id_asignacion = $_POST["AsignacionId"];
        $id_profesor = $_POST["ProfesorId"];
        $id_clase = $_POST["ClaseId"];

        if (!empty($id_asignacion) && !empty($id_profesor) && !empty($id_clase)) {
            $respuesta = $asignacion->actualizarAsignacion($id_asignacion, $id_profesor, $id_clase);
            echo json_encode($respuesta);
        } else {
            echo json_encode(['message' => 'Todos los campos son obligatorios']);
        }
    break;

    case "eliminar":
        $id_asignacion = $_POST["id_asignacion"] ?? null;

        if (!empty($id_asignacion)) {
            $eliminado = $asignacion->eliminarAsignacion($id_asignacion);
            if ($eliminado) {
                echo json_encode("Asignación eliminada");
            } else {
                echo json_encode("Error al eliminar asignación");
            }
        } else {
            echo json_encode(array("message" => "El ID de la asignación es obligatorio"));
        }
    break;

    case "listarAsignacionesCombo":
        $datos = $asignacion->listarAsignacionesCombo();
        echo json_encode($datos);
        break;

}
?>
