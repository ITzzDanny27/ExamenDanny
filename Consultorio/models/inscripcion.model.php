<?php

require_once("../config/conexion copy.php");

class Clase_Inscripcion {

    public function listarInscripciones() {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "SELECT i.id_inscripcion, e.nombre AS nombre_estu, e.apellido AS apellido_estu, p.nombre, p.apellido, c.nombre_clases, i.fecha_inscripcion FROM inscripciones AS i
                INNER JOIN estudiantes AS e ON e.estudiante_id = i.id_estudiante
                INNER JOIN asignaciones AS a ON a.asignacion_id = i.id_asignacion
                INNER JOIN profesores AS p ON p.profesor_id = a.profesor_id
                INNER JOIN clases AS c ON c.clase_id = a.clase_id";


        $datos = mysqli_query($con, $sql);
        $con->close();
        return $datos;
    }
    
    // public function listarInscripciones() {
    //     $conexion = new Clase_Conectar();
    //     $con = $conexion->conectar();

    //     $sql = "SELECT i.id_inscripcion, e.nombre AS nombre_estudiante, e.apellido AS apellido_estudiante, 
    //                    p.nombre_profesor, p.apellido_profesor, c.nombre_clase, c.descripcion, i.fecha_inscripcion 
    //             FROM inscripciones AS i
    //             INNER JOIN estudiantes AS e ON e.id_estudiante = i.id_estudiante
    //             INNER JOIN asignaciones AS a ON a.id_asignacion = i.id_asignacion
    //             INNER JOIN profesores AS p ON p.id_profesor = a.id_profesor
    //             INNER JOIN clases AS c ON c.id_clase = a.id_clase";

    //     $datos = mysqli_query($con, $sql);
    //     $con->close();
    //     return $datos;
    // }

    public function registrarInscripcion($estudiante_id , $asignacion_id) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "INSERT INTO inscripciones (id_estudiante , id_asignacion) VALUES (?, ?)";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $estudiante_id , $asignacion_id );
        $stmt->execute();
        $stmt->close();
        $con->close();
    }

    public function actualizarInscripcion($id_inscripcion, $id_estudiante, $id_asignacion) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "UPDATE inscripciones 
                SET id_estudiante = ?, id_asignacion = ?, fecha_inscripcion = CURRENT_DATE 
                WHERE id_inscripcion = ?";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("iii", $id_estudiante, $id_asignacion, $id_inscripcion);
        $resultado = $stmt->execute();

        if ($resultado) {
            $respuesta = array("message" => "Inscripción actualizada correctamente");
        } else {
            $respuesta = array("message" => "Error al actualizar la inscripción: " . $stmt->error);
        }

        $stmt->close();
        $con->close();

        return $respuesta;
    }

    public function eliminarInscripcion($id_inscripcion) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "DELETE FROM inscripciones WHERE id_inscripcion = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id_inscripcion);
        $resultado = $stmt->execute();

        if ($resultado) {
            $respuesta = array("message" => "Inscripción eliminada correctamente");
        } else {
            $respuesta = array("message" => "Error al eliminar la inscripción: " . $stmt->error);
        }

        $stmt->close();
        $con->close();

        return $respuesta;
    }

    public function uno($id_inscripcion) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "SELECT i.id_inscripcion, e.nombre AS nombre_estudiante, e.apellido AS apellido_estudiante, 
                       p.nombre_profesor, p.apellido_profesor, c.nombre_clase, c.descripcion, i.fecha_inscripcion 
                FROM inscripciones AS i
                INNER JOIN estudiantes AS e ON e.id_estudiante = i.id_estudiante
                INNER JOIN asignaciones AS a ON a.id_asignacion = i.id_asignacion
                INNER JOIN profesores AS p ON p.id_profesor = a.id_profesor
                INNER JOIN clases AS c ON c.id_clase = a.id_clase
                WHERE i.id_inscripcion = ?";

        $stmt = $con->prepare($sql);
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $con->error);
        }

        $stmt->bind_param("i", $id_inscripcion);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();
        $stmt->close();
        $con->close();
        return $fila;
    }

    // public function listarEstudiantes() {
    //     $conexion = new Clase_Conectar();
    //     $con = $conexion->conectar();

    //     $sql = "SELECT id_estudiante, nombre, apellido FROM estudiantes";
    //     $result = $con->query($sql);
    //     $con->close();
    //     return $result;
    // }

    // public function listarAsignaciones() {
    //     $conexion = new Clase_Conectar();
    //     $con = $conexion->conectar();

    //     $sql = "SELECT a.id_asignacion, p.nombre_profesor, p.apellido_profesor, c.nombre_clase 
    //             FROM asignaciones AS a
    //             INNER JOIN profesores AS p ON p.id_profesor = a.id_profesor
    //             INNER JOIN clases AS c ON c.id_clase = a.id_clase";
    //     $result = $con->query($sql);
    //     $con->close();
    //     return $result;
    // }
}
?>
