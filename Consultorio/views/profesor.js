// Inicialización
function init() {
    $("#frm_profesores").on("submit", function (e) {
        guardarProfesor(e);
    });
    $("#frm_editar_profesores").on("submit", function (e) {
        editar(e);
    });
}

$(document).ready(() => {
    cargaTabla();
    cargarDepartamentos();
});

// Cargar la tabla de profesores
var cargaTabla = () => {
    var html = "";

    $.get("../controllers/profesor.controller.php?op=listar", (response) => {
        let listaProfesores;
        try {
            listaProfesores = JSON.parse(response);
        } catch (e) {
            console.error("Error parsing JSON:", e);
            return;
        }

        if (Array.isArray(listaProfesores)) {
            $.each(listaProfesores, (indice, unProfesor) => {
                html += `
                    <tr>
                        <td>${indice + 1}</td>
                        <td>${unProfesor.nombre}</td>
                        <td>${unProfesor.apellido}</td>
                        <td>${unProfesor.especialidad}</td>
                        <td>${unProfesor.email}</td>
                        <td>
                            <button class="btn btn-primary" onclick="cargarProfesor(${unProfesor.profesor_id})">Editar</button>
                            <button class="btn btn-danger" onclick="eliminar(${unProfesor.profesor_id})">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $("#cuerpoprofesores").html(html);
        } else {
            console.error("Expected an array but got:", listaProfesores);
        }
    });
}

var buscarProfesor = (id_profe) => {
    $.get("../controllers/profesor.controller.php?op=uno&id=" + id_profe, (Profesor) => {
        try{
            var Profesor = JSON.parse(Profesor);

            if(Profesor && Profesor.id_profesor){
                console.log("Profesor encontrado:", Profesor);
                var html = "";
                html += `
                    <tr>
                        <td>${Profesor.id_profesor}</td>
                        <td>${Profesor.nombre_profesor}</td>
                        <td>${Profesor.apellido_profesor}</td>
                        <td>${Profesor.nombre_departamento}</td>
                        <td>
                            <button class="btn btn-primary" onclick="cargarProfesor(${Profesor.id_profesor})">Editar</button>
                            <button class="btn btn-danger" onclick="eliminar(${Profesor.id_profesor})">Eliminar</button>
                        </td>
                    </tr>
                `;

                $("#cuerpoprofesores").html(html);
            }else{
                console.error("Profesor no encontrado:", Profesor);
                cargaTabla();
            }

        }catch(e){
            console.error("Error parsing JSON:", e);
        }
        
    });
}



var cargarProfesor = (id_profesor) =>{
    console.log(id_profesor);
    $.get("../controllers/profesor.controller.php?op=uno&id="+ id_profesor, (data) => {
        var Profesor = JSON.parse(data);
        console.log("Clase encontrada:", Profesor);

        $("#EditarProfesoresId").val(Profesor.id_profesor);
        $("#EditarNombre").val(Profesor.nombre_profesor);
        $("#EditarApellido").val(Profesor.apellido_profesor);
        $("#EditarDepartamento").val(Profesor.nombre_departamento);
        $("#modalEditarProfesor").modal("show");
    });
}



function cargarDepartamentos() {
    $.get("../controllers/profesor.controller.php?op=listarDepartamentos", (response) => {
        let listaDepartamentos = JSON.parse(response);
        let html = "<option value=''>Seleccione un departamento</option>";
        $.each(listaDepartamentos, (index, unDepartamento) => {
            html += `<option value='${unDepartamento.nombre_departamento}'>${unDepartamento.nombre_departamento}</option>`;
        });
        $("#Departamento").html(html);
        $("#EditarDepartamento").html(html);
    });
}

var guardarProfesor = (e) => {
    e.preventDefault();
    var frm_profesores = new FormData($("#frm_profesores")[0]);
    var ruta = "../controllers/profesor.controller.php?op=insertar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_profesores,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            location.reload();
            $("#modalProfesor").modal("hide");
        },
        error: function (xhr, status, error) {
            console.error("Error al guardar:", error);
        }
    });
}

var editar = (e) => {
    e.preventDefault();

    var frm_editar_profesores = new FormData($("#frm_editar_profesores")[0]);
    var ruta = "../controllers/profesor.controller.php?op=actualizar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_editar_profesores,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            $("#modalEditarProfesor").modal("hide");
            cargaTabla();
        },
        error: function (xhr, status, error) {
            console.error("Error al actualizar:", error);
        }
    });
};

// Eliminar un estudiante
var eliminar = (ProfesoresId) => {
    Swal.fire({
        title: "Profesores",
        text: "¿Está seguro que desea eliminar el profesor?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Eliminar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../controllers/profesor.controller.php?op=eliminar",
                type: "POST",
                data: { id_profesor: ProfesoresId },
                success: (resultado) => {
                    console.log("Respuesta del servidor:", resultado);
                    try {
                        let response = JSON.parse(resultado);
                        if (response === "Profesor eliminado") {
                            Swal.fire({
                                title: "Profesores",
                                text: "Se eliminó con éxito",
                                icon: "success",
                            });
                            cargaTabla();
                        }
                    } catch (e) {
                        Swal.fire({
                            title: "Profesores",
                            text: "No se pudo eliminar al profesor debido a que ya se encuentra registrado en una CLASE",
                            icon: "error",
                        });
                        console.error("Error al parsear JSON:", e);
                    }
                },
                error: () => {
                    Swal.fire({
                        title: "Profesores", 
                        text: "Ocurrió un error al intentar eliminar",
                        icon: "error",
                    });
                }
            });
        }
    });
};

init();