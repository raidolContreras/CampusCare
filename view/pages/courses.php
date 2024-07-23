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
                    <th>Acciones</th>
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
                        return `
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                    Acciones
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#" onclick="editCourse(${data.idCourse})">Editar</a>
                                    <a class="dropdown-item" href="#" onclick="deleteCourse(${data.idCourse})">Eliminar</a>
                                </div>
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
</script>