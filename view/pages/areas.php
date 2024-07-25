<div class="container">
    <h2>Areas Registradas</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addAreaModal">Registrar Nueva Area</button>
    <div class="table-responsive">
        <table id="areasTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre del area</th>
                    <th width="10%">Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal Agregar Área -->
<div class="modal fade" id="addAreaModal" tabindex="-1" role="dialog" aria-labelledby="addAreaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAreaModalLabel">Registrar Nueva Área</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addAreaForm">
                    <div class="form-group">
                        <label for="addAreaName">Nombre del área</label>
                        <input type="text" class="form-control" id="addAreaName" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Área -->
<div class="modal fade" id="editAreaModal" tabindex="-1" role="dialog" aria-labelledby="editAreaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAreaModalLabel">Editar Área</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editAreaForm">
                    <input type="hidden" id="editAreaId">
                    <div class="form-group">
                        <label for="editAreaName">Nombre del área</label>
                        <input type="text" class="form-control" id="editAreaName" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Eliminar Área -->
<div class="modal fade" id="deleteAreaModal" tabindex="-1" role="dialog" aria-labelledby="deleteAreaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAreaModalLabel">Eliminar Área</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar esta área?</p>
                <input type="hidden" id="deleteAreaId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteArea">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = initializeDataTable();

        // Handle add area form submission
        $('#addAreaForm').on('submit', function(e) {
            e.preventDefault();
            var nameArea = $('#addAreaName').val();

            $.ajax({
                url: 'controller/ajax/ajax.forms.php',
                type: 'POST',
                data: {
                    search: 'areas',
                    addArea: true,
                    nameArea: nameArea
                },
                success: function(response) {
                    $('#addAreaModal').modal('hide');
                    table.ajax.reload();
                    alert('Área registrada exitosamente');
                },
                error: function(xhr, status, error) {
                    console.error('Error registrando el área:', error);
                    alert('Hubo un error al registrar el área. Por favor, inténtelo de nuevo.');
                }
            });
        });

        // Handle edit area form submission
        $('#editAreaForm').on('submit', function(e) {
            e.preventDefault();
            var idArea = $('#editAreaId').val();
            var nameArea = $('#editAreaName').val();

            $.ajax({
                url: 'controller/ajax/ajax.forms.php',
                type: 'POST',
                data: {
                    search: 'areas',
                    editArea: idArea,
                    nameArea: nameArea
                },
                success: function(response) {
                    $('#editAreaModal').modal('hide');
                    table.ajax.reload();
                    alert('Área actualizada exitosamente');
                },
                error: function(xhr, status, error) {
                    console.error('Error actualizando el área:', error);
                    alert('Hubo un error al actualizar el área. Por favor, inténtelo de nuevo.');
                }
            });
        });

        // Handle delete area confirmation
        $('#confirmDeleteArea').on('click', function() {
            var idArea = $('#deleteAreaId').val();

            $.ajax({
                url: 'controller/ajax/ajax.forms.php',
                type: 'POST',
                data: {
                    search: 'areas',
                    deleteArea: idArea
                },
                success: function(response) {
                    $('#deleteAreaModal').modal('hide');
                    table.ajax.reload();
                    alert('Área eliminada exitosamente');
                },
                error: function(xhr, status, error) {
                    console.error('Error eliminando el área:', error);
                    alert('Hubo un error al eliminar el área. Por favor, inténtelo de nuevo.');
                }
            });
        });
    });

    function editArea(idArea) {
        $.ajax({
            url: 'controller/ajax/ajax.forms.php',
            type: 'POST',
            data: {search: 'areas', area: idArea },
            success: function(data) {
                var area = JSON.parse(data);
                $('#editAreaId').val(area.idArea);
                $('#editAreaName').val(area.nameArea);
                $('#editAreaModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error obteniendo el área:', error);
                alert('Hubo un error al obtener los datos del área. Por favor, inténtelo de nuevo.');
            }
        });
    }

    function deleteArea(idArea) {
        $('#deleteAreaId').val(idArea);
        $('#deleteAreaModal').modal('show');
    }
    
    function initializeDataTable() {
        return $('#areasTable').DataTable({
            ajax: {
                type: 'POST',
                url: "controller/ajax/ajax.forms.php",
                dataSrc: '',
                data: {search: 'areas'}
            },
            columns: [
                { "data": "idArea" },
                { "data": "nameArea" },
                {
                    "data": null,
                    "render": function (data) {
                        return `
                            <div class="btn-group" role="group" aria-label="Acciones">
                                <button type="button" class="btn btn-primary" onclick="editArea(${data.idArea})"><i class="fad fa-edit"></i></button>
                                <button type="button" class="btn btn-danger" onclick="deleteArea(${data.idArea})"><i class="fad fa-trash-alt"></i></button>
                            </div>`;
                    }
                }
            ],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            }
        });
    }
</script>
