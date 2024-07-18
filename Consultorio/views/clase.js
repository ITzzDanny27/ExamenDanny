// Inicialización
function init() {
    $("#frm_clases").on("submit", function (e) {
        guardar(e);
    });

    $("#frm_editar_clase").on("submit", function (e) {
        editar(e);
    });
}

$(document).ready(() => {
    cargaTabla();
});

// Cargar la tabla de clases
var cargaTabla = () => {
    var html = "";

    $.get("../controllers/clase.controller.php?op=listar", (response) => {
        let listaClases;
        try {
            listaClases = JSON.parse(response);
        } catch (e) {
            console.error("Error parsing JSON:", e);
            return;
        }

        if (Array.isArray(listaClases)) {
            $.each(listaClases, (indice, unClase) => {
                html += `
                    <tr>
                        <td>${indice + 1}</td>
                        <td>${unClase.nombre_clases}</td>
                        <td>${unClase.descripcion}</td>
                        <td>
                            <button class="btn btn-primary" onclick="cargarClase(${unClase.clase_id})">Editar</button>
                            <button class="btn btn-danger" onclick="eliminar(${unClase.clase_id})">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $("#cuerpoclases").html(html);
        } else {
            console.error("Expected an array but got:", listaClases);
        }
    });
};


var cargarClase = (id_clase) => {
    $.get("../controllers/clase.controller.php?op=uno&id=" + id_clase, (data) => {
        var Clase = JSON.parse(data);
        console.log("Clase encontrada:", Clase);
        $("#EditarClaseId").val(Clase.clase_id);
        $("#NombreE").val(Clase.nombre_clases);
        $("#DescripcionE").val(Clase.descripcion);

        $("#modalEditarClase").modal("show");
    });
}

var guardar = (e) => {
    
    e.preventDefault();

    var frm_clases= new FormData($("#frm_clases")[0]);
    console.log("Datos del formulario:", frm_clases);

    var ruta = "../controllers/clase.controller.php?op=insertar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_clases,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            location.reload();
            $("#modalClase").modal("hide");
        },
        error: function (xhr, status, error) {
            console.error("Error al guardar:", error);
        }
    });
}


var editar = (e) => {
    e.preventDefault();

    var frm_editar_clase = new FormData($("#frm_editar_clase")[0]);
    var ruta = "../controllers/clase.controller.php?op=actualizar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_editar_clase,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            $("#modalEditarClase").modal("hide");
            cargaTabla();
        },
        error: function (xhr, status, error) {
            console.error("Error al actualizar:", error);
        }
    });
};

// Eliminar una Clase
var eliminar = (ClasesId) => {
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
                url: "../controllers/clase.controller.php?op=eliminar",
                type: "POST",
                data: { ClasesId: ClasesId },
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