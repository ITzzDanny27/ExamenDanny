<?php

require_once("../models/inscripcion.model.php");

$inscripcion = new Clase_Inscripcion();

switch($_GET["op"]) {

    case "listar":
        $ListaInscripciones = array();
        $dato = $inscripcion->listarInscripciones();

        while($fila = mysqli_fetch_assoc($dato)) {
            $ListaInscripciones[] = $fila;
        }

        if (!empty($ListaInscripciones)) {
            echo json_encode($ListaInscripciones);
        } else {
            echo json_encode(['message' => 'No hay inscripciones registradas']);
        }
    break;

    case "uno":
        if (isset($_GET["id"])) {
            $dato = $inscripcion->uno($_GET["id"]);
            if ($dato) {
                echo json_encode($dato);
            } else {
                echo json_encode(['message' => 'La inscripción no existe']);
            }
        }
    break;

    case "insertar":
        $estudiante_id = $_POST["ID_Estudiante"];
        $asignacion_id = $_POST["Asignacion"];

        if (!empty($estudiante_id) && !empty($asignacion_id)) {
            $respuesta = $inscripcion->registrarInscripcion($estudiante_id, $asignacion_id);
            echo json_encode($respuesta);
        } else {
            echo "Faltan datos";
        }
    break;

    case "actualizar":
        $id_inscripcion = $_POST["EditarIncripcionId"];
        $id_estudiante = $_POST["ID_EstudianteE"];
        $id_asignacion = $_POST["AsignacionE"];

        if (!empty($id_inscripcion) && !empty($id_estudiante) && !empty($id_asignacion)) {
            $respuesta = $inscripcion->actualizarInscripcion($id_inscripcion, $id_estudiante, $id_asignacion);
            echo json_encode($respuesta);
        } else {
            echo json_encode(['message' => 'Todos los campos son obligatorios']);
        }
    break;

    case "eliminar":
        $id_inscripcion = $_POST["id_inscripcion"] ?? null;

        if (!empty($id_inscripcion)) {
            $eliminado = $inscripcion->eliminarInscripcion($id_inscripcion);
            if ($eliminado) {
                echo json_encode("Inscripción eliminada");
            } else {
                echo json_encode("Error al eliminar inscripción");
            }
        } else {
            echo json_encode(array("message" => "El ID de la inscripción es obligatorio"));
        }
    break;

    // case "listarEstudiantes":
    //     $listaEstudiantes = array();
    //     $dato = $inscripcion->listarEstudiantes();

    //     while($fila = mysqli_fetch_assoc($dato)) {
    //         $listaEstudiantes[] = $fila;
    //     }

    //     echo json_encode($listaEstudiantes);
    // break;

    // case "listarAsignaciones":
    //     $listaAsignaciones = array();
    //     $dato = $inscripcion->listarAsignaciones();

    //     while($fila = mysqli_fetch_assoc($dato)) {
    //         $listaAsignaciones[] = $fila;
    //     }

    //     echo json_encode($listaAsignaciones);
    // break;
}
?>
