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

<!-- Modal para editar curso -->
<div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="editCourseModalLabel">Editar Curso</h5>
            </div>
            <div class="modal-body">
                <form id="editCourseForm">
                    <input type="hidden" id="editCourseId" name="idCourse">
                    <div class="form-group">
                        <label for="editNameCourse">Nombre del curso:</label>
                        <input type="text" class="form-control" id="editNameCourse" name="nameCourse" placeholder="Ingrese el nombre del curso" required>
                    </div>
                    <div class="row my-3">
                        <div class="form-group col-6">
                            <label for="editStartCourse">Fecha de inicio:</label>
                            <input type="date" class="form-control" id="editStartCourse" name="startCourse" required>
                        </div>
                        <div class="form-group col-6">
                            <label for="editEndCourse">Fecha de finalización:</label>
                            <input type="date" class="form-control" id="editEndCourse" name="endCourse" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function() {
    var table = initializeDataTable();

    $('.registerCourseModal').on('click', function(e) {
        $('#registerCourseForm')[0].reset();
        $('#registerCourseModal').modal('show');
    });

    // Inicializa DataTable
    function initializeDataTable() {
        return $('#coursesTable').DataTable({
            ajax: {
                type: 'POST',
                url: "controller/ajax/ajax.forms.php",
                dataSrc: '',
                data: { search: 'courses' }
            },
            columns: [
                { "data": null },
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
            },
            rowCallback: function(row, data, index) {
                // Agregar el índice incrementable
                $('td:eq(0)', row).html(index + 1);
            }
        });
    }

    // Añadir curso
    $('#registerCourseForm').on('submit', function(event) {
        event.preventDefault();
        var formData = $(this).serializeArray(); // Serializa el formulario a un array de objetos
        formData.push({ name: 'search', value: 'courses' });
        formData.push({ name: 'addCourse', value: true });

        $.ajax({
            url: 'controller/ajax/ajax.forms.php',
            method: 'POST',
            data: $.param(formData),
            success: function(response) {
                $('#registerCourseForm')[0].reset();
                $('#registerCourseModal').modal('hide');
                table.ajax.reload();
            }
        });
        return false;
    });

    // Activar curso
    window.activeCourse = function(idCourse) {
        $.ajax({
            url: 'controller/ajax/ajax.activateCourse.php',
            type: 'POST',
            data: { idCourse: idCourse },
            success: function(response) {
                table.ajax.reload();
                alert('Curso activado exitosamente');
            },
            error: function(xhr, status, error) {
                console.error('Error activando el curso:', error);
                alert('Hubo un error al activar el curso. Por favor, inténtelo de nuevo.');
            }
        });
    }

    // Editar curso
    window.editCourse = function(idCourse) {
        $.ajax({
            url: 'controller/ajax/ajax.forms.php',
            type: 'POST',
            data: { search: 'courses', idCourse: idCourse },
            success: function(response) {
                var course = JSON.parse(response);
                $('#editCourseId').val(course.idCourse);
                $('#editNameCourse').val(course.nameCourse);
                $('#editStartCourse').val(course.startCourse);
                $('#editEndCourse').val(course.endCourse);
                $('#editCourseModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error cargando los datos del curso:', error);
                alert('Hubo un error al cargar los datos del curso. Por favor, inténtelo de nuevo.');
            }
        });
    }

    // Guardar cambios al editar curso
    $('#editCourseForm').on('submit', function(event) {
        event.preventDefault();
        var formData = $(this).serializeArray(); // Serializa el formulario a un array de objetos
        formData.push({ name: 'search', value: 'courses' });
        formData.push({ name: 'editCourse', value: true });

        $.ajax({
            url: 'controller/ajax/ajax.forms.php',
            method: 'POST',
            data: $.param(formData),
            success: function(response) {
                $('#editCourseForm')[0].reset();
                $('#editCourseModal').modal('hide');
                table.ajax.reload();
            }
        });
        return false;
    });

    // Eliminar curso
    window.deleteCourse = function(idCourse) {
        if (confirm('¿Estás seguro de que quieres eliminar este curso?')) {
            $.ajax({
                url: 'controller/ajax/ajax.forms.php',
                type: 'POST',
                data: { deleteCourse: idCourse, search: 'courses' },
                success: function(response) {
                    table.ajax.reload();
                    alert('Curso eliminado exitosamente');
                },
                error: function(xhr, status, error) {
                    console.error('Error eliminando el curso:', error);
                    alert('Hubo un error al eliminar el curso. Por favor, inténtelo de nuevo.');
                }
            });
        }
    }
});

</script>