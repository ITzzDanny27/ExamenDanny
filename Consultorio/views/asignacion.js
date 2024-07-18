// Inicialización
function init() {
    $("#frm_asignaciones").on("submit", function (e) {
        guardarAsignacion(e);
    });

    $("#frm_editar_inscripciones").on("submit", function (e) {
        editar(e);
    });
}

$(document).ready(() => {
    cargaTabla();
    cargarProfesores();
    cargarClases();
});

// Cargar la tabla de inscripcion
var cargaTabla = () => {
    var html = "";

    $.get("../controllers/asignacion.controller.php?op=listar", (response) => {
        let listaInscripciones;
        try {
            listaInscripciones = JSON.parse(response);
        } catch (e) {
            console.error("Error parsing JSON:", e);
            return;
        }

        if (Array.isArray(listaInscripciones)) {
            $.each(listaInscripciones, (indice, unInscripcion) => {
                html += `
                    <tr>
                        <td>${indice + 1}</td>
                        <td>${unInscripcion.nombre}</td>
                        <td>${unInscripcion.apellido}</td>
                        <td>${unInscripcion.nombre_clases}</td>
                        <td>
                            <button class="btn btn-primary" onclick="cargarInscripcion(${unInscripcion.asignacion_id})">Editar</button>
                            <button class="btn btn-danger" onclick="eliminar(${unInscripcion.asignacion_id})">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $("#cuerpoasignaciones").html(html);
        } else {
            console.error("Expected an array but got:", listaInscripciones);
        }
    });
};


// var cargarInscripcion = (id) => {
//     $.get("../controllers/inscripcion.controller.php?op=uno&id=" + id, (data) => {
//         var Inscripcion = JSON.parse(data);
//         console.log("ID de la inscripción:", id);
//         console.log("Datos de la inscripción:", Inscripcion);

//         $("#EditarInscripcionesId").val(Inscripcion.id_inscripcion);
//         $("#EditarCedula_Estudiante").val(Inscripcion.id_estudiante);
//         $("#EditarNombre").val(Inscripcion.nombre);
//         $("#EditarApellido").val(Inscripcion.apellido);
//         $("#EditarCurso").val(Inscripcion.nombre_curso);
//         $("#EditarFechaInscripcion").val(Inscripcion.fecha_inscripcion);
//         $("#modalEditarInscripcion").modal("show");
//     }).fail(function () {
//         Swal.fire({
//             title: "Inscripción",
//             text: "Ocurrió un error al intentar obtener los datos de la inscripción",
//             icon: "error",
//         });
//     });
// }

function cargarProfesores() {
    $.get("../controllers/profesor.controller.php?op=listarProfesoresCombo", (response) => {
        let listaProfesores = JSON.parse(response);
        console.log(listaProfesores);
        let html = "<option value=''>Seleccione un Profesor</option>";
        $.each(listaProfesores, (index, profesor) => {
            html += `<option value='${profesor.profesor_id}'>${profesor.nombre} ${profesor.apellido}</option>`;
        });
        $("#Profesores").html(html);
        $("#ProfesoresE").html(html);
    });
}

// function cargarClase() {
//     $.get("../controllers/clase.controller.php?op=listarClasesCombos", (response) => {
//         let listaClases = JSON.parse(response);
//         let html = "<option value=''>Seleccione una Clase</option>";
//         $.each(listaClases, (index, clase) => {
//             html += `<option value='${clase.clase_id}'>${clase.clase_id} - ${clase.nombre}</option>`;
//             //html += `<option value='${clase.clase_id}'>${clase.nombre}</option>`;
//             //`<option value='${clase.nombre}'>${clase.nombre}</option>`;
//         });
//         $("#Clases").html(html);
//         $("#ClasesE").html(html);
//     });
// }

// function cargarClase() {
//     $.get("../controllers/clase.controller.php?op=listarClasesCombos", (response) => {
//         let listaClases = JSON.parse(response);
//         let html = "<option value=''>Seleccione un Clase</option>";
//         $.each(listaClases, (index, clase) => {
//             html += `<option value='${clase.nombre}'>${clase.nombre}</option>`;
//         });
//         $("#Clases").html(html);
//         $("#ClasesE").html(html);
//     });
// }

function cargarClases() {
    $.get("../controllers/clase.controller.php?op=listarClasesCombos", (response) => {
        let listaClases = JSON.parse(response);
        let html = "<option value=''>Seleccione una Clase</option>";
        $.each(listaClases, (index, clase) => {
            html += `<option value='${clase.clase_id}'>${clase.nombre_clases}</option>`;
        });
        $("#Clases").html(html);
        $("#ClasesE").html(html);
    });
}

// var buscarEstudianteInc = (id_estudiante) => {
//     $.get("../controllers/inscripcion.controller.php?op=unoEstudiante&id=" + id_estudiante, (data) => {
//         try {
//             var listaInscripciones = JSON.parse(data);
            
//             if (Array.isArray(listaInscripciones) && listaInscripciones.length > 0) {
//                 var html = "";
                
//                 $.each(listaInscripciones, (indice, unaInscripcion) => {            
//                     html += `
//                         <tr>
//                             <td>${unaInscripcion.id_estudiante}</td>
//                             <td>${unaInscripcion.nombre}</td>
//                             <td>${unaInscripcion.apellido}</td>
//                             <td>${unaInscripcion.nombre_curso}</td>
//                             <td>${unaInscripcion.fecha_inscripcion}</td>
//                             <td>
//                                 <button class="btn btn-primary" onclick="cargarInscripcion(${unaInscripcion.id_inscripcion})">Editar</button>
//                                 <button class="btn btn-danger" onclick="eliminar(${unaInscripcion.id_inscripcion})">Eliminar</button>
//                             </td>
//                         </tr>
//                     `;
//                 });

//                 $("#cuerpoinscripciones").html(html);
//             } else {
//                 console.error("Estudiante no encontrado o no hay inscripciones:", listaInscripciones);
//                 cargaTabla();
//             }
            
//         } catch (e) {
//             console.error("Error parsing JSON:", e);
//             cargaTabla();
//         }
//     }).fail(function() {
//         console.error("Error al obtener las inscripciones del estudiante.");
//         cargaTabla();
//     });
// }


var guardarAsignacion = (e) =>{
    e.preventDefault();
    var frm_asignaciones = new FormData($("#frm_asignaciones")[0]);
    var ruta = "../controllers/asignacion.controller.php?op=insertar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_asignaciones,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            location.reload();
            $("#modalAsignacion").modal("hide");
        },
        error: function (xhr, status, error) {
            console.error("Error al guardar:", error);
        }
    });

};

// var guardarAsignacion = (e) => {
//     e.preventDefault();
//     var profesorId = $("#Profesores").val();
//     var claseId = $("#Clases").val();

//     if (!profesorId || !claseId) {
//         alert("Todos los campos son obligatorios.");
//         return;
//     }

//     $.ajax({
//         url: "../controllers/asignacion.controller.php?op=insertar",
//         type: "POST",
//         data: {
//             Profesores: profesorId,
//             Clases: claseId
//         },
//         success: function (datos) {
//             console.log(datos);
//             $("#modalAsignacion").modal("hide");
//             cargaTabla();
//         },
//         error: function (xhr, status, error) {
//             console.error("Error al guardar:", error);
//         }
//     });
// };

var editar = (e) => {
    e.preventDefault();

    var frm_editar_inscripciones = new FormData($("#frm_editar_inscripciones")[0]);
    var ruta = "../controllers/inscripcion.controller.php?op=actualizar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_editar_inscripciones,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            $("#modalEditarInscripcion").modal("hide");
            cargaTabla();
        },
        error: function (xhr, status, error) {
            console.error("Error al actualizar:", error);
        }
    });
};

// Eliminar una inscripción
var eliminar = (InscripcionesId) => {
    Swal.fire({
        title: "Inscripción",
        text: "¿Está seguro que desea eliminar el inscripcion?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Eliminar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../controllers/asignacion.controller.php?op=eliminar",
                type: "POST",
                data: { id_asignacion: InscripcionesId },
                success: (resultado) => {
                    console.log("Respuesta del servidor:", resultado);
                    try {
                        let response = JSON.parse(resultado);
                        if (response === "Inscripcion eliminado") {
                            Swal.fire({
                                title: "Inscripción",
                                text: "Se eliminó con éxito",
                                icon: "success",
                            });
                            cargaTabla();
                        }location.reload();
                    } catch (e) {
                        Swal.fire({
                            title: "Inscripción",
                            text: "No se pudo eliminar la inscripcion debido a que ya está registrado en otra tabla",
                            icon: "error",
                        });
                        console.error("Error al parsear JSON:", e);
                    }
                },
                error: () => {
                    Swal.fire({
                        title: "Inscripción", 
                        text: "Ocurrió un error al intentar eliminar",
                        icon: "error",
                    });
                }
            });
        }
    });
};

init();