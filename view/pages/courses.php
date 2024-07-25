<div class="container">
    <h2>Cursos Registrados</h2>
    <button class="btn btn-primary mb-3 registerCourseModal">Registrar Curso Nuevo</button>
    <div class="table-responsive">
        <table id="coursesTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre del curso</th>
                    <th>Fecha de inicio</th>
                    <th>Fecha de finalización</th>
                    <th width="10%">Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal para registrar curso nuevo -->
<div class="modal fade" id="registerCourseModal" tabindex="-1" aria-labelledby="registerCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="registerCourseModalLabel">Registrar Curso Nuevo</h5>
            </div>
            <div class="modal-body">
                <form id="registerCourseForm">
                    <div class="form-group">
                        <label for="nameCourse">Nombre del curso:</label>
                        <input type="text" class="form-control" id="nameCourse" name="nameCourse" placeholder="Ingrese el nombre del curso" required>
                    </div>
                    <div class="row my-3">
                        <div class="form-group col-6">
                            <label for="startCourse">Fecha de inicio:</label>
                            <input type="date" class="form-control" id="startCourse" name="startCourse" required>
                        </div>
                        <div class="form-group col-6">
                            <label for="endCourse">Fecha de finalización:</label>
                            <input type="date" class="form-control" id="endCourse" name="endCourse" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Registrar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>

    var table = initializeDataTable();

    $('.registerCourseModal').on('click', function(e) {
        $('#nameCourse').val('');
        $('#startCourse').val('');
        $('#endCourse').val('');
        $('#registerCourseModal').modal('show');
    });
    
    function initializeDataTable() {
        return $('#coursesTable').DataTable({
            ajax: {
                url: "controller/ajax/ajax.getCourses.php",
                dataSrc: ''
            },
            columns: [
                { "data": "idCourse" },
                { "data": "nameCourse" },
                { "data": "startCourse" },
                { "data": "endCourse" },
                {
                    "data": null,
                    "render": function (data) {
                        let activateButton = '';
                        if (data.active == 0) {
                            activateButton = `<button type="button" class="btn btn-success" onclick="activeCourse(${data.idCourse})"><i class="fad fa-check"></i></button>`;
                        } else {
                            activateButton = `<button type="button" class="btn btn-success" disabled><i class="fad fa-check"></i></button>`;
                        }

                        return `
                            <div class="btn-group" role="group" aria-label="Acciones">
                                ${activateButton}
                                <button type="button" class="btn btn-primary" onclick="editCourse(${data.idCourse})"><i class="fad fa-edit"></i></button>
                                <button type="button" class="btn btn-danger" onclick="deleteCourse(${data.idCourse})"><i class="fad fa-trash-alt"></i></button>
                            </div>`;
                    }
                }
            ],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            }
        });
    }
    
    // Función para añadir un curso
    $('#registerCourseForm').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: 'controller/ajax/ajax.addCourse.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert(response);
                if (response ==='success') {
                    $('#registerCourseForm')[0].reset();
                    $('#registerCourseModal').modal('hide');
                    table.ajax.reload();
                }
            }
        });
        return false;
    });
    
    function activeCourse(idCourse) {
        $.ajax({
            url: 'controller/ajax/ajax.activateCourse.php',
            type: 'POST',
            data: {
                idCourse: idCourse
            },
            success: function(response) {
                $('#coursesTable').DataTable().ajax.reload();
                alert('Curso activado exitosamente');
            },
            error: function(xhr, status, error) {
                // Manejo de errores
                console.error('Error activando el curso:', error);
                alert('Hubo un error al activar el curso. Por favor, inténtelo de nuevo.');
            }
        });
    }
</script>