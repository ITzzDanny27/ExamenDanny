<?php
require_once("../config/conexion copy.php");

class Recepcionista_Clase {

    public function listarRecepcionista() {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql = "SELECT * FROM recepcionista";
        $datos = mysqli_query($con, $sql);
    
        if ($datos === false) {
            return "Error al listar";
        }
    
        $con->close(); 
        return $datos;
    }
    
    public function uno($idRecepcionista)
    {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "SELECT * FROM recepcionista WHERE ID_RECEPCIONISTA = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $idRecepcionista);
        $stmt->execute();
        $datos = $stmt->get_result()->fetch_assoc(); 
        $con->close();
        return $datos;
    }

    public function registrarRecepcionista($nombre, $apellido, $telefono, $correo_electronico, $password) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql = "INSERT INTO recepcionista (NOMBRE, APELLIDO, TELEFONO, CORREO_ELECTRONICO, PASSWORD) VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssss", $nombre, $apellido, $telefono, $correo_electronico, $password);
        if ($stmt->execute()) {
            return "Registro exitoso";
        } else {
            return "Error al registrar";
        }
        $con->close();
    }
    
    public function actualizarRecepcionista($id_recepcionista, $nombre, $apellido, $telefono, $correo_electronico, $password) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql = "UPDATE recepcionista SET NOMBRE = ?, APELLIDO = ?, TELEFONO = ?, CORREO_ELECTRONICO = ?, PASSWORD = ? WHERE ID_RECEPCIONISTA = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssssi", $nombre, $apellido, $telefono, $correo_electronico, $password, $id_recepcionista);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        $con->close();
    }
    
    public function eliminarRecepcionista($id_recepcionista) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        
        $sql = "DELETE FROM recepcionista WHERE ID_RECEPCIONISTA = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id_recepcionista);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        $con->close();
    }

    public function buscarRecepcionista($nombre) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql = "SELECT * FROM recepcionista WHERE NOMBRE = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $con->close();
        return $resultado;
    }
}
?>
