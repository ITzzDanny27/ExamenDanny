// Inicialización
function init() {
    $("#frm_inscripcion").on("submit", function (e) {
        guardar(e);
    });

    $("#frm_editar_inscripcion").on("submit", function (e) {
        editar(e);
    });
}

$(document).ready(() => {
    cargaTabla();
    cargarEstudiantes();
    cargarAsignaciones();
});

// Cargar la tabla de clases
var cargaTabla = () => {
    var html = "";

    $.get("../controllers/inscripcion.controller.php?op=listar", (response) => {
        let listaInscripcion;
        try {
            listaInscripcion = JSON.parse(response);
        } catch (e) {
            console.error("Error parsing JSON:", e);
            return;
        }

        if (Array.isArray(listaInscripcion)) {
            $.each(listaInscripcion, (indice, unInscripcion) => {
                html += `
                    <tr>
                        <td>${indice + 1}</td>
                        <td>${unInscripcion.nombre_estu}</td>
                        <td>${unInscripcion.apellido_estu}</td>
                        <td>${unInscripcion.nombre}</td>
                        <td>${unInscripcion.apellido}</td>
                        <td>${unInscripcion.nombre_clases}</td>
                        <td>${unInscripcion.fecha_inscripcion}</td>
                        <td>
                            <button class="btn btn-primary" onclick="cargarInscripcion(${unInscripcion.id_inscripcion})">Editar</button>
                            <button class="btn btn-danger" onclick="eliminar(${unInscripcion.id_inscripcion})">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $("#cuerpoinscripcion").html(html);
        } else {
            console.error("Expected an array but got:", listaInscripcion);
        }
    });
};


var cargarInscripcion = (id_inscripcion) => {
    $.get("../controllers/inscripcion.controller.php?op=uno&id=" + id_inscripcion, (data) => {
        var Clase = JSON.parse(data);
        console.log("Clase encontrada:", Clase);
        $("#EditarIncripcionId").val(Clase.id_inscripcion);
        $("#ID_EstudianteE").val(Clase.id_estudiante);
        $("#AsignacionE").val(Clase.id_asignacion);

        $("#modalEditarInscripcion").modal("show");
    });
}

function cargarEstudiantes(){
    $.get("../controllers/estudiante.controller.php?op=listarComboEstudiantes", (response) => {
        let listaEstudiante = JSON.parse(response);
        console.log(listaEstudiante);
        let html = "<option value=''>Seleccione un Estudiante</option>";
        $.each(listaEstudiante, (index, estudiante) => {
            html += `<option value='${estudiante.estudiante_id}'>${estudiante.nombre} ${estudiante.apellido}</option>`;
            //html += `<option value='${estudiante.nombre} ${estudiante.apellido}</option>`;
        });
        $("#ID_Estudiante").html(html);
        $("#ID_EstudianteE").html(html);
    });
}

function cargarAsignaciones() {
    $.get("../controllers/asignacion.controller.php?op=listarAsignacionesCombo", (response) => {
        let listaAsignaciones = JSON.parse(response);
        let html = "<option value=''>Seleccione una la asignacion</option>";
        $.each(listaAsignaciones, (index, Asignacion) => {
            html += `<option value='${Asignacion.asignacion_id}'>${Asignacion.asignacion_info}</option>`;
        });
        $("#Asignacion").html(html);
        $("#AsignacionE").html(html);
    });
}

var guardar = (e) => {
    
    e.preventDefault();

    var frm_inscripcion= new FormData($("#frm_inscripcion")[0]);
    console.log("Datos del formulario:", frm_inscripcion);

    var ruta = "../controllers/inscripcion.controller.php?op=insertar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_inscripcion,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            location.reload();
            $("#modalInscripcion").modal("hide");
        },
        error: function (xhr, status, error) {
            console.error("Error al guardar:", error);
        }
    });
}

var editar = (e) => {
    e.preventDefault();

    var frm_editar_inscripcion = new FormData($("#frm_editar_inscripcion")[0]);
    var ruta = "../controllers/inscripcion.controller.php?op=actualizar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_editar_inscripcion,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            $("#modalEditarInscripcion").modal("hide");
            cargaTabla();
            location.reload();

        },
        error: function (xhr, status, error) {
            console.error("Error al actualizar:", error);
        }
    });
};

// Eliminar una Clase
var eliminar = (IncripcionId) => {
    Swal.fire({
        title: "Clase",
        text: "¿Está seguro que desea eliminar la Clase?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Eliminar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../controllers/inscripcion.controller.php?op=eliminar",
                type: "POST",
                data: { id_inscripcion: IncripcionId},
                success: (resultado) => {
                    console.log("Respuesta del servidor:", resultado);
                    try {
                        let response = JSON.parse(resultado);
                        if (response === "Clase eliminado") {
                            Swal.fire({
                                title: "Clase",
                                text: "Se eliminó con éxito",
                                icon: "success",
                            });
                            cargaTabla();
                            
                        }location.reload();
                    } catch (e) {
                        Swal.fire({
                            title: "Clase",
                            text: "No se pudo eliminar la clase debido a que ya está registrado en otra tabla",
                            icon: "error",
                        });
                        console.error("Error al parsear JSON:", e);
                    }
                },
                error: () => {
                    Swal.fire({
                        title: "Clase", 
                        text: "Ocurrió un error al intentar eliminar",
                        icon: "error",
                    });
                }
            });
        }
    });
};

init();