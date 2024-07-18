<?php

require_once("../models/profesor.model.php");

$profesor = new Clase_Profesor();

switch ($_GET["op"]) {

    case "listar":
        $ListaProfesores = array();
        $dato = $profesor->listarProfesores();
    
        while ($fila = mysqli_fetch_assoc($dato)) {
            $ListaProfesores[] = $fila;
        }
    
        if (!empty($ListaProfesores)) {
            echo json_encode($ListaProfesores);
        } else {
            echo json_encode(['message' => 'No hay profesores registrados']);
        }
        
        break;

    case "uno":
        if (isset($_GET["id"])) {
            $dato = $profesor->uno(intval($_GET["id"]));
            if ($dato) {
                echo json_encode($dato);
            } else {
                echo json_encode(['message' => 'El profesor no existe']);
            }
        } else {
            echo json_encode(['message' => 'El ID del profesor es obligatorio']);
        }
        break;

    case "insertar":
        $nombre = $_POST["Nombre"] ?? null;
        $apellido = $_POST["Apellido"] ?? null;
        $especialidad = $_POST["Especialidad"] ?? null;
        $email = $_POST["Email"] ?? null;

        if (!empty($nombre) && !empty($apellido) && !empty($especialidad) && !empty($email)) {
            $respuesta = $profesor->registrarProfesor($nombre, $apellido, $especialidad, $email);
            echo json_encode($respuesta);
        } else {
            echo json_encode(['message' => 'Todos los campos son obligatorios']);
        }
        break;

    case "actualizar":
        $id_profesor = $_POST["EditarProfesoresId"] ?? null;
        $nombre = $_POST["EditarNombre"] ?? null;
        $apellido = $_POST["EditarApellido"] ?? null;
        $especialidad = $_POST["EspecialidadE"] ?? null;
        $email = $_POST["EditarEmail"] ?? null;

        if (!empty($id_profesor) && !empty($nombre) && !empty($apellido) && !empty($especialidad) && !empty($email)) {
            $respuesta = $profesor->actualizarProfesor($id_profesor, $nombre, $apellido, $especialidad, $email);
            echo json_encode($respuesta);
        } else {
            echo json_encode(['message' => 'Todos los campos son obligatorios']);
        }
        break;

    case "eliminar":
        $id_profesor = $_POST["id_profesor"] ?? null;

        if (!empty($id_profesor)) {
            $eliminado = $profesor->eliminarProfesor($id_profesor);
            if ($eliminado) {
                echo json_encode(['message' => 'Profesor eliminado']);
            } else {
                echo json_encode(['message' => 'Error al eliminar profesor']);
            }
        } else {
            echo json_encode(['message' => 'El ID del profesor es obligatorio']);
        }
        break;

    case "listarProfesoresCombo":
        $listaProfesores = array();
        $dato = $profesor->listarComboProfesores();

        while ($fila = mysqli_fetch_assoc($dato)) {
            $listaProfesores[] = $fila;
        }
        echo json_encode($listaProfesores);
        break;
    
    default:
        echo json_encode(['message' => 'Operación no válida']);
        break;
}
?>
