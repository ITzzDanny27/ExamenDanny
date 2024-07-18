<?php 

require_once("../config/conexion copy.php");

class Clase {

    public function listarClases() {
        $conectar = new Clase_Conectar();
        $con = $conectar->conectar();
        $sql = "SELECT clase_id, nombre_clases, descripcion FROM clases";
        
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();    
        return $result;
    }

    public function registrarClase($nombre_clases, $descripcion) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "INSERT INTO clases (nombre_clases, descripcion) VALUES (?, ?)";
        
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $nombre_clases, $descripcion);

        $resultado = $stmt->execute();

        if ($resultado) {
            $respuesta = array("message" => "Clase registrada correctamente");
        } else {
            $respuesta = array("message" => "Error al registrar la clase: " . $stmt->error);
        }

        $stmt->close();
        $con->close();

        return $respuesta;
    }

    public function actualizarClase($clase_id, $nombre_clases, $descripcion) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "UPDATE clases SET nombre_clases = ?, descripcion = ? WHERE clase_id = ?";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("sss", $nombre_clases, $descripcion, $clase_id);

        $resultado = $stmt->execute();

        if ($resultado) {
            $respuesta = array("message" => "Clase actualizada correctamente");
        } else {
            $respuesta = array("message" => "Error al actualizar la clase: " . $stmt->error);
        }

        $stmt->close();
        $con->close();

        return $respuesta;
    }

    public function eliminarClase($clase_id) {
        $conectar = new Clase_Conectar();
        $con = $conectar->conectar();
        $sql = "DELETE FROM clases WHERE clase_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $clase_id);
        $resultado = $stmt->execute();

        if ($resultado) {
            $respuesta = array("message" => "Clase eliminada correctamente");
        } else {
            $respuesta = array("message" => "Error al eliminar la clase: " . $stmt->error);
        }

        $stmt->close();
        $con->close();

        return $respuesta;
    }

    public function uno($clase_id){
        $conectar = new Clase_Conectar();
        $con = $conectar->conectar();
        
        $sql = "SELECT clase_id, nombre_clases, descripcion FROM clases WHERE clase_id = ?";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $clase_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result;
    }

    // public function listarClasesCombo() {
    //     $conexion = new Clase_Conectar();
    //     $con = $conexion->conectar();
    //     $sql = "SELECT c.nombre FROM clases c";
    //     $datos = mysqli_query($con, $sql);

    //     if ($datos === false) {
    //         return "Error al listar";
    //     }

    //     $con->close();
    //     return $result;
    // }

    public function listarClasesCombo() {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "SELECT c.clase_id, c.nombre_clases FROM clases c";

        $result = $con->query($sql);
        //$con->close();
        return $result;
    }

}
