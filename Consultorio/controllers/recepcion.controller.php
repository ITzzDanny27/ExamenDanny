<?php 

require_once("../models/recepcion.model.php");

$recepcionista = new Recepcionista_Clase();
$metodo = $_SERVER['REQUEST_METHOD'];

switch($_GET["op"]){
    
    case 'uno':
        if (isset($_GET["id"])) {
            $idRecepcionista = intval($_GET["id"]);
            $datos = $recepcionista->uno($idRecepcionista);
            echo json_encode($datos);
        } else {
            echo json_encode(array("message" => "ID no proporcionado"));
        }
        break;

    case "listar":
        $recepcionistas = array();
        $datos = $recepcionista->listarRecepcionista();
        
        if ($datos !== "Error al listar") {
            while ($row = mysqli_fetch_assoc($datos)) {
                $recepcionistas[] = $row;
            }
            echo json_encode($recepcionistas);
        } else {
            echo json_encode("Error al listar");
        }
        break;
    
    case "insertar":
        $nombre = $_POST["Nombre"] ?? null;
        $apellido = $_POST["Apellido"] ?? null;
        $telefono = $_POST["Telefono"] ?? null;
        $correo_electronico = $_POST["Correo"] ?? null;
        $password = $_POST["Contrasena"] ?? null;

        if (!empty($nombre) && !empty($apellido) && !empty($telefono) && !empty($correo_electronico) && !empty($password)) {
            $registro = $recepcionista->registrarRecepcionista($nombre, $apellido, $telefono, $correo_electronico, $password);
            echo json_encode($registro);
        } else {
            echo json_encode("Faltan Datos");
        }
        break;

    case "actualizar":
        $id_recepcionista = $_POST["EditarRecepcionistaId"] ?? null;
        $nombre = $_POST["EditarNombre"] ?? null;
        $apellido = $_POST["EditarApellido"] ?? null;
        $telefono = $_POST["EditarTelefono"] ?? null;
        $correo_electronico = $_POST["EditarCorreo_Electronico"] ?? null;
        $password = $_POST["EditarPassword"] ?? null;

        if (!empty($id_recepcionista) && !empty($nombre) && !empty($apellido) && !empty($telefono) && !empty($correo_electronico) && !empty($password)) {
            $actualizado = $recepcionista->actualizarRecepcionista($id_recepcionista, $nombre, $apellido, $telefono, $correo_electronico, $password);
            if ($actualizado) {
                echo json_encode("Actualizado");
            } else {
                echo json_encode("Error al actualizar");
            }
        } else {
            echo json_encode("Faltan Datos");
        }
        break;

    case "eliminar":
        if (isset($_POST["id_recepcionista"])) {
            $id_recepcionista = intval($_POST["id_recepcionista"]);
            $eliminado = $recepcionista->eliminarRecepcionista($id_recepcionista);
            if ($eliminado) {
                echo json_encode(array("message" => "Eliminado correctamente"));
            } else {
                echo json_encode(array("message" => "Error al eliminar"));
            }
        } else {
            echo json_encode(array("message" => "ID no proporcionado"));
        }
        break;

    case "buscar":
        $nombre = $_POST["Nombre"] ?? null;
        if (!empty($nombre)) {
            $datos = $recepcionista->buscarRecepcionista($nombre);
            $recepcionistas = array();
            while ($row = mysqli_fetch_assoc($datos)) {
                $recepcionistas[] = $row;
            }
            echo json_encode($recepcionistas);
        } else {
            echo json_encode("Faltan Datos");
        }
        break;
}

?>
