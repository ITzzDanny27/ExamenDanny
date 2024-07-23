<!DOCTYPE html>
<html lang='es'>

<head>
    <?php require_once('./html/head.php') ?>
    <link href='../public/lib/calendar/lib/main.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
    .custom-flatpickr {
        display: flex;
        align-items: center;
    }

    .custom-flatpickr input {
        margin-right: 5px;
        flex: 1;
    }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class='container-xxl position-relative bg-white d-flex p-0'>
        <!-- Spinner Start -->
        <div id='spinner'
            class='show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center'>
            <div class='spinner-border text-primary' style='width: 3rem; height: 3rem;' role='status'>
                <span class='sr-only'>Cargando...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <?php require_once('./html/menu.php') ?>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class='content'>
            <!-- Navbar Start -->
            <?php require_once('./html/header.php') ?>
            <!-- Navbar End -->


            <!-- Nuevo Clase Modal -->
            <div class="modal fade" id="modalInscripcion" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Nueva Incripcion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="frm_inscripcion">
                            <div class="modal-body">
                                <input type="hidden" name="IncripcionId" id="IncripcionId">

                                <div class="form-group">
                                    <label for="ID_Estudiante">Estudiante</label>
                                    <select name="ID_Estudiante" id="ID_Estudiante" class="form-control" required>
                                        
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="Asignacion">Asignacion</label>
                                    <select name="Asignacion" id="Asignacion" class="form-control" required>
                                        
                                    </select>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin Nuevo Clase Modal -->

            <!-- Editar Clase Modal -->
            <div class="modal fade" id="modalEditarInscripcion" tabindex="-1" aria-labelledby="editarInscripcionLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editarInscripcionLabel">Editar Inscripcion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="frm_editar_inscripcion">
                            <div class="modal-body">
                                <input type="hidden" name="EditarIncripcionId" id="EditarIncripcionId">

                                <div class="form-group">
                                    <label for="ID_EstudianteE">Estudiante</label>
                                    <select name="ID_EstudianteE" id="ID_EstudianteE" class="form-control" required>
                                        
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="AsignacionE">Asignacion</label>
                                    <select name="AsignacionE" id="AsignacionE" class="form-control" required>
                                        
                                    </select>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin Editar Clase Modal -->

            <!-- Lista de Clase -->
            <div class='container-fluid pt-4 px-4'>
                <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#modalInscripcion">
                <i class="bi bi-file-earmark-plus-fill"></i> Nueva Inscripcion
                </button>
                <h6 style="text-align: center; color: #FFFFFF;" class='mb-4'> Lista de Inscripcion</h6>
                <div class='d-flex align-items-center justify-content-between mb-4'>
                    <table class="table table-bordered table-striped table-hover table-responsive">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nombre Estudiante</th>
                                <th>Apellido Estudiante</th>
                                <th>Nombre Profesor</th>
                                <th>Apellido Profesor</th>
                                <th>Clase</th>
                                <th>Fecha Inscripcion</th>

                            </tr>
                        </thead>
                        <tbody id="cuerpoinscripcion">
                            <!-- Aquí van los datos de los productos -->
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Fin Lista de Clase -->


            <!-- Widgets Start -->
            <!-- Aquí podrías agregar widgets relacionados con productos si lo deseas -->
            <!-- Widgets End -->


            <!-- Footer Start -->
            <?php require_once('./html/footer.php') ?>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href='#' class='btn btn-lg btn-primary btn-lg-square back-to-top'><i class='bi bi-arrow-up'></i></a>
    </div>


    <!-- JavaScript Libraries -->
    <?php require_once('./html/scripts.php') ?>
    <script src="inscripcion.js"></script>

</body>

</html>