<?php

require_once("../config/conexion copy.php");

class Clase_Estudiante{

    public function uno($estudiante_id) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
    
        $sql = "SELECT estudiante_id, nombre, apellido, fecha_nacimiento, grado FROM estudiantes WHERE estudiante_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $estudiante_id); // Cambiado a "i" para entero
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();   
        return $result;
    }
    
    public function listar_estudiantes(){
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql ="SELECT estudiante_id,nombre, apellido, fecha_nacimiento, grado FROM estudiantes";

        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function registrarEstudiante($nombre, $apellido, $fecha_nacimiento, $grado){
        $conexion= new Clase_Conectar();
        $con = $conexion->conectar();
        $sql="INSERT INTO estudiantes (nombre, apellido, fecha_nacimiento, grado) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        $stmt->bind_param("ssss", $nombre, $apellido, $fecha_nacimiento, $grado);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
        
        $con->close();
    }
    
    public function actualizarEstudiante($estudiante_id, $nombre, $apellido, $fecha_nacimiento, $grado){
        $conexion= new Clase_Conectar();
        $con = $conexion->conectar();
        $sql="UPDATE estudiantes SET nombre=?, apellido=?, fecha_nacimiento=?, grado=? WHERE estudiante_id=?";
        $stmt = mysqli_prepare($con, $sql);
        $stmt->bind_param("ssssi", $nombre, $apellido, $fecha_nacimiento, $grado, $estudiante_id); // Cambiado a "i" para el ID
        stmt->execute();
        $con->close();
    }

    public function eliminarEstudiante($estudiante_id){
        $conexion= new Clase_Conectar();
        $con = $conexion->conectar();
        $sql="DELETE FROM estudiantes WHERE estudiante_id=?";
        $stmt = mysqli_prepare($con, $sql);
        $stmt->bind_param("i", $estudiante_id); // Cambiado a "i" para el ID

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

        $con->close();
    }

    public function listarComboEstudiante(){
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql = "SELECT e.estudiante_id ,e.nombre, e.apellido FROM estudiantes e";
        $result = $con->query($sql);
        return $result;
    }

}
?>
