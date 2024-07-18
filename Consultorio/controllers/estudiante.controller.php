<?php

require_once("../models/estudiante.model.php");
$estudiante = new Clase_Estudiante();

switch($_GET["op"]){

    case "uno":
        if (isset($_GET["id"])) {
            $estudiante_id = intval($_GET["id"]);
            $datos = $estudiante->uno($estudiante_id);
            echo json_encode($datos);
        } else {
            echo json_encode(array("message" => "ID no proporcionado"));
        }
        break;

    case "listar":
        $ListaEstudiantes = array();
        $dato = $estudiante->listar_estudiantes();

        while ($fila = mysqli_fetch_assoc($dato)) {
            $ListaEstudiantes[] = $fila;
        }

        if (!empty($ListaEstudiantes)) {
            echo json_encode($ListaEstudiantes);
        } else {
            echo json_encode(array("message" => "No hay estudiantes"));
        }
    break;

    case "insertar":
        $nombre = $_POST["Nombre"] ?? null;
        $apellido = $_POST["Apellido"] ?? null;
        $fecha_nacimiento = $_POST["FechaNacimiento"] ?? null;
        $grado = $_POST["Grado"] ?? null;

        if (!empty($nombre) && !empty($apellido) && !empty($fecha_nacimiento) && !empty($grado)) {
            $registro = $estudiante->registrarEstudiante($nombre, $apellido, $fecha_nacimiento, $grado);
            echo json_encode($registro);
        } else {
            echo json_encode("Faltan Datos");
        }
        break;

    case "actualizar":
            // Verificar si se han recibido todos los campos necesarios
        if (
            isset($_POST["EditarEstudianteId"], $_POST["NombreE"], $_POST["ApellidoE"], $_POST["GradoE"]) &&
            !empty($_POST["EditarEstudianteId"]) &&
            !empty($_POST["NombreE"]) &&
            !empty($_POST["ApellidoE"]) &&
            !empty($_POST["GradoE"])
            ) {
                $estudiante_id = $_POST["EditarEstudianteId"];
                $nombre = $_POST["NombreE"];
                $apellido = $_POST["ApellidoE"];
                $fecha_nacimiento = $_POST["FechaNacimientoE"] ?? null;
                $grado = $_POST["GradoE"];
        
                // Llamar a la función de actualización del estudiante
                $estudiante->actualizarEstudiante($estudiante_id, $nombre, $apellido, $fecha_nacimiento, $grado);
                echo json_encode("Estudiante actualizado");
            } else {
                echo json_encode("Faltan Datos");
            }
        break;
        

    case "eliminar":
        $estudiante_id = $_POST["id_estudiante"] ?? null;

        if (!empty($estudiante_id)) {
            $eliminado = $estudiante->eliminarEstudiante($estudiante_id);
            if ($eliminado) {
                echo json_encode("Estudiante eliminado");
            } else {
                echo json_encode("Error al eliminar estudiante");
            }
        } else {
            echo json_encode("Faltan Datos");
        }
        break;

    case "listarComboEstudiantes":

        $estudiantelista = array();
        $dato = $estudiante->listarComboEstudiante();

        while ($row = mysqli_fetch_assoc($dato)) {
            $estudiantelista[] = $row;
        }
        echo json_encode($estudiantelista);

    break;

    default:
        echo json_encode(array("message" => "Operación no válida"));
        break;
}
?>
