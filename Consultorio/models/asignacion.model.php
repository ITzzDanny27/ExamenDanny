<?php

require_once("../config/conexion copy.php");

class Clase_Asignacion {

    public function listarAsignaciones() {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "SELECT a.asignacion_id, p.nombre, p.apellido, c.nombre_clases FROM asignaciones AS a
                INNER JOIN profesores AS p ON p.profesor_id = a.profesor_id
                INNER JOIN clases AS c ON c.clase_id = a.clase_id";

        $datos = mysqli_query($con, $sql);
        $con->close();
        return $datos;
    }

    public function registrarAsignacion($profesor_id, $clase_id) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
    
        $sql = "INSERT INTO asignaciones (profesor_id, clase_id) 
                VALUES (?, ?)";
    
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $profesor_id, $clase_id);
        $stmt->execute();   
        $stmt->close();
        $con->close();
    }
    

    public function actualizarAsignacion($asignacion_id, $profesor_id, $clase_id) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "UPDATE asignaciones 
                SET profesor_id = ?, clase_id = ? 
                WHERE asignacion_id = ?";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("iii", $profesor_id, $clase_id, $asignacion_id);
        $resultado = $stmt->execute();

        if ($resultado) {
            $respuesta = array("message" => "Asignación actualizada correctamente");
        } else {
            $respuesta = array("message" => "Error al actualizar la asignación: " . $stmt->error);
        }

        $stmt->close();
        $con->close();

        return $respuesta;
    }

    public function eliminarAsignacion($asignacion_id) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "DELETE FROM asignaciones WHERE asignacion_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $asignacion_id);
        $resultado = $stmt->execute();

        if ($resultado) {
            $respuesta = array("message" => "Asignación eliminada correctamente");
        } else {
            $respuesta = array("message" => "Error al eliminar la asignación: " . $stmt->error);
        }

        $stmt->close();
        $con->close();

        return $respuesta;
    }

    public function uno($asignacion_id) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "SELECT a.asignacion_id, p.nombre AS nombre_profesor, p.apellido AS apellido_profesor, p.especialidad, p.email, 
                c.nombre AS nombre_clase, c.descripcion 
                FROM asignaciones AS a
                INNER JOIN profesores AS p ON p.profesor_id = a.profesor_id
                INNER JOIN clases AS c ON c.clase_id = a.clase_id
                WHERE a.asignacion_id = ?";

        $stmt = $con->prepare($sql);
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $con->error);
        }

        $stmt->bind_param("i", $asignacion_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();
        $stmt->close();
        $con->close();
        return $fila;
    }

    public function listarAsignacionesCombo() {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "SELECT a.asignacion_id, CONCAT(p.nombre, ' ', p.apellido, ' - ', c.nombre_clases) AS asignacion_info 
                FROM asignaciones AS a
                INNER JOIN profesores AS p ON p.profesor_id = a.profesor_id
                INNER JOIN clases AS c ON c.clase_id = a.clase_id";

        $datos = mysqli_query($con, $sql);
        $asignaciones = array();
        while ($row = mysqli_fetch_assoc($datos)) {
            $asignaciones[] = $row;
        }
        $con->close();
        return $asignaciones;
    }

    // public function listarAsignacionesCombo(){
    //     $conexion = new Clase_Conectar();
    //     $con = $conexion->conectar();

    //     $sql = "SELECT p.nombre, p.apellido FROM profesores p";
        
    //     $result = $con->query($sql);
    //     return $result;
    // }

}
?>
