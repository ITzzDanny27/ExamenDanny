<?php

require_once("../config/conexion copy.php");

class Clase_Profesor{

    public function listarProfesores() {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql = "SELECT profesor_id, nombre, apellido, especialidad, email FROM profesores";
        
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();    
        return $result;
    }

    public function registrarProfesor($nombre, $apellido, $especialidad, $email) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "INSERT INTO profesores (nombre, apellido, especialidad, email) VALUES (?, ?, ?, ?)";
        
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $apellido, $especialidad, $email);

        $resultado = $stmt->execute();

        if ($resultado) {
            $respuesta = array("message" => "Profesor registrado correctamente");
        } else {
            $respuesta = array("message" => "Error al registrar el profesor: " . $stmt->error);
        }

        $stmt->close();
        $con->close();

        return $respuesta;
    }

    public function actualizarProfesor($profesor_id, $nombre, $apellido, $especialidad, $email) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "UPDATE profesores 
                SET nombre = ?, apellido = ?, especialidad = ?, email = ?
                WHERE profesor_id = ?";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $apellido, $especialidad, $email, $profesor_id);

        $resultado = $stmt->execute();

        if ($resultado) {
            $respuesta = array("message" => "Profesor actualizado correctamente");
        } else {
            $respuesta = array("message" => "Error al actualizar el profesor: " . $stmt->error);
        }

        $stmt->close();
        $con->close();

        return $respuesta;
    }

    public function eliminarProfesor($profesor_id) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql = "DELETE FROM profesores WHERE profesor_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $profesor_id); // Cambiado a "i" para entero
        $resultado = $stmt->execute();

        if ($resultado) {
            $respuesta = array("message" => "Profesor eliminado correctamente");
        } else {
            $respuesta = array("message" => "Error al eliminar el profesor: " . $stmt->error);
        }

        $stmt->close();
        $con->close();

        return $respuesta;
    }

    public function uno($profesor_id){
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        
        $sql = "SELECT profesor_id, nombre, apellido, especialidad, email FROM profesores WHERE profesor_id = ?";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $profesor_id); // Cambiado a "i" para entero
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result;
    }

    public function listarComboProfesores(){
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql = "SELECT p.profesor_id ,p.nombre, p.apellido FROM profesores p";
        
        $result = $con->query($sql);
        return $result;
    }
}
?>
