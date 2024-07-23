<div class="container">
    <h2>Eventos Registrados</h2>
    <button class="btn btn-primary mb-3 registerEventModal">Registrar Evento Nuevo</button>
    <div class="table-responsive">
        <table id="eventsTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Evento</th>
                    <th>Nombre del Evento</th>
                    <th>Fecha</th>
                    <th>Ubicación</th>
                    <th>Hora de Inicio</th>
                    <th>Hora de Fin</th>
                    <th>Puntos</th>
                    <th>Vacantes Disponibles</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal para registrar evento nuevo -->
<div class="modal fade" id="registerEventModal" tabindex="-1" aria-labelledby="registerEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="registerEventModalLabel">Registrar Evento Nuevo</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registerEventForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="eventTypeId" class="form-label">Tipo de Evento</label>
                            <input type="text" class="form-control" id="eventTypeId" name="eventTypeId" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="eventName" class="form-label">Nombre del Evento</label>
                            <input type="text" class="form-control" id="eventName" name="eventName" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="location" class="form-label">Ubicación</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_time" class="form-label">Hora de Inicio</label>
                            <input type="time" class="form-control" id="start_time" name="start_time" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_time" class="form-label">Hora de Fin</label>
                            <input type="time" class="form-control" id="end_time" name="end_time" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="points" class="form-label">Puntos</label>
                            <input type="number" class="form-control" id="points" name="points" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="vacancies_available" class="form-label">Vacantes Disponibles</label>
                            <input type="number" class="form-control" id="vacancies_available" name="vacancies_available" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar evento -->
<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="editEventModalLabel">Editar Evento</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editEventForm">
                    <input type="hidden" id="editEventId" name="idEvent">
                    <div class="mb-3">
                        <label for="editEventTypeId" class="form-label">Tipo de Evento</label>
                        <input type="text" class="form-control" id="editEventTypeId" name="eventTypeId" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEventName" class="form-label">Nombre del Evento</label>
                        <input type="text" class="form-control" id="editEventName" name="eventName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDate" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="editDate" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="editLocation" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="editLocation" name="location" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStartTime" class="form-label">Hora de Inicio</label>
                        <input type="time" class="form-control" id="editStartTime" name="start_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEndTime" class="form-label">Hora de Fin</label>
                        <input type="time" class="form-control" id="editEndTime" name="end_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPoints" class="form-label">Puntos</label>
                        <input type="number" class="form-control" id="editPoints" name="points" required>
                    </div>
                    <div class="mb-3">
                        <label for="editVacanciesAvailable" class="form-label">Vacantes Disponibles</label>
                        <input type="number" class="form-control" id="editVacanciesAvailable" name="vacancies_available" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Descripción</label>
                        <textarea class="form-control" id="editDescription" name="description" rows="4" required></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-block">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Set minimum date for event registration and editing
        var minDate = getMinDate();
        setMinDate('date', minDate);
        setMinDate('editDate', minDate);

        // Attach event listeners for form submissions
        attachSubmitListener('registerEventForm', 'start_time', 'end_time');
        attachSubmitListener('editEventForm', 'editStartTime', 'editEndTime');
    });

    $(document).ready(function() {
        // Initialize DataTable
        var table = initializeDataTable();

        // Handle registration form submission
        $('#registerEventForm').on('submit', function(event) {
            handleFormSubmission(event, table, 'controller/ajax/ajax.addEvent.php', '#registerEventForm', '#registerEventModal');
        });

        // Handle editing form submission
        $('#editEventForm').on('submit', function(event) {
            handleFormSubmission(event, table, 'controller/ajax/ajax.updateEvent.php', '#editEventForm', '#editEventModal');
        });

        // Show register event modal
        $('.registerEventModal').on('click', function() {
            $('#registerEventModal').modal('show');
        });
    });

    function getMinDate() {
        var today = new Date();
        var tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        var dd = String(tomorrow.getDate()).padStart(2, '0');
        var mm = String(tomorrow.getMonth() + 1).padStart(2, '0'); // January is 0!
        var yyyy = tomorrow.getFullYear();
        return yyyy + '-' + mm + '-' + dd;
    }

    function setMinDate(elementId, minDate) {
        var dateInput = document.getElementById(elementId);
        if (dateInput) {
            dateInput.setAttribute('min', minDate);
        }
    }

    function attachSubmitListener(formId, startTimeId, endTimeId) {
        document.getElementById(formId).addEventListener('submit', function(event) {
            var startTime = document.getElementById(startTimeId).value;
            var endTime = document.getElementById(endTimeId).value;
            if (startTime >= endTime) {
                event.preventDefault();
                alert('La hora de fin debe ser mayor que la hora de inicio y no pueden ser iguales.');
                return false;
            }
        });
    }

    function initializeDataTable() {
        return $('#eventsTable').DataTable({
            ajax: {
                url: "controller/ajax/ajax.getEvents.php",
                dataSrc: ''
            },
            columns: [
                { "data": "idEvent" },
                { "data": "eventTypeId" },
                { "data": "eventName" },
                { "data": "date" },
                { "data": "location" },
                { "data": "start_time" },
                { "data": "end_time" },
                { "data": "points" },
                { "data": "vacancies_available" },
                { "data": "description" },
                {
                    "data": null,
                    "render": function (data) {
                        return `
                            <div class="btn-group" role="group" aria-label="Acciones">
                                <button type="button" class="btn btn-primary" onclick="editEvent(${data.idEvent})"><i class="fad fa-edit"></i></button>
                                <button type="button" class="btn btn-danger" onclick="deleteEvent(${data.idEvent})"><i class="fad fa-trash-alt"></i></button>
                            </div>`;
                    }
                }
            ],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            }
        });
    }

    function handleFormSubmission(event, table, url, formSelector, modalSelector) {
        event.preventDefault();
        var form = $(formSelector);
        var startTime = form.find('[name="start_time"]').val();
        var endTime = form.find('[name="end_time"]').val();

        if (startTime >= endTime) {
            alert('La hora de fin debe ser mayor que la hora de inicio y no pueden ser iguales.');
            return false;
        }

        $.ajax({
            url: url,
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                alert(response);
                if (response === 'success') {
                    form[0].reset();
                    $(modalSelector).modal('hide');
                    table.ajax.reload();
                }
            }
        });
    }

    function editEvent(idEvent) {
        $.ajax({
            url: 'controller/ajax/ajax.getEvent.php',
            method: 'POST',
            data: { idEvent: idEvent },
            success: function(response) {
                var event = JSON.parse(response);
                $('#editEventId').val(event.idEvent);
                $('#editEventTypeId').val(event.eventTypeId);
                $('#editEventName').val(event.eventName);
                $('#editDate').val(event.date);
                $('#editLocation').val(event.location);
                $('#editStartTime').val(event.start_time);
                $('#editEndTime').val(event.end_time);
                $('#editPoints').val(event.points);
                $('#editVacanciesAvailable').val(event.vacancies_available);
                $('#editDescription').val(event.description);
                $('#editEventModal').modal('show');
            }
        });
    }

    function deleteEvent(idEvent) {
        if (confirm('¿Estás seguro de que quieres eliminar este evento?')) {
            $.ajax({
                url: 'controller/ajax/ajax.deleteEvent.php',
                method: 'POST',
                data: { idEvent: idEvent },
                success: function(response) {
                    alert(response);
                    if (response === 'success') {
                        $('#eventsTable').DataTable().ajax.reload();
                    }
                }
            });
        }
    }
</script>
