
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
    getUsers();
    // Initialize DataTable
    var table = initializeDataTable();
    var tableTypesEvents = initializeDataTableTypesEvents();
    var areas = areaEncargada();

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
        options();
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

function formatDateTime(dateTimeString) {
    const months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    
    const date = new Date(dateTimeString);
    
    const day = date.getDate();
    const month = months[date.getMonth()];
    const year = date.getFullYear();
    
    let hours = date.getHours();
    const minutes = date.getMinutes();
    const ampm = hours >= 12 ? 'PM' : 'AM';
    
    hours = hours % 12;
    hours = hours ? hours : 12; // la hora '0' debe ser '12'
    
    const minutesFormatted = minutes < 10 ? '0'+minutes : minutes;

    return `${day} de ${month} del ${year}, ${hours}:${minutesFormatted} ${ampm}`;
}

function initializeDataTable() {
    return $('#eventsTable').DataTable({
        ajax: {
            url: "controller/ajax/ajax.getEvents.php",
            dataSrc: ''
        },
        columns: [
            { "data": null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { "data": "name" },
            { "data": "eventName" },
            { "data": null,
                render: function (data) {
                    return formatDateTime(data.date + ' ' +data.start_time);
                }
            },
            { "data": "location" },
            { "data": "points" },
            { "data": "vacancies_available" },
            { "data": "description" },
            {
                "data": null,
                "render": function (data) {
                    return `
                        <div class="btn-group btn-block" role="group" aria-label="Acciones">
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

function initializeDataTableTypesEvents() {
    return $('#eventTypesTable').DataTable({
        ajax: {
            type: 'POST',
            url: "controller/ajax/ajax.forms.php",
            dataSrc: '',
            data: {
                search: 'event_types'
            }
        },
        columns: [
            { "data": "idEventType" },
            { "data": "name" },
            { "data": "nameArea" },
            { "data": "pointsPerEvent" },
            { "data": "benefitsPerYear" },
            {
                "data": null,
                "render": function (data) {
                    return `
                        <div class="btn-group" role="group" aria-label="Acciones">
                            <button type="button" class="btn btn-primary" onclick="editTypeEvent(${data.idEventType}, '${data.name}', ${data.idArea}, ${data.pointsPerEvent}, ${data.benefitsPerYear})"><i class="fad fa-edit"></i></button>
                            <button type="button" class="btn btn-danger" onclick="deleteTypeEvent(${data.idEventType})"><i class="fad fa-trash-alt"></i></button>
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
        dataType: 'json',
        success: function(event) {
            options(event.eventTypeId);  // Pasar el idEventType a la función options
            $('#editEventId').val(event.idEvent);
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

function options(selectedEventTypeId) {
    $.ajax({
        url: 'controller/ajax/ajax.forms.php',
        dataType: 'json',
        type: 'POST',
        data: {
            search: 'event_types'
        },
        success: function(response) {
            var options = '<option value="">Seleccione un tipo de evento</option>';
            response.forEach(function(typeEvent) {
                options += '<option value="' + typeEvent.idEventType + '">' + typeEvent.name + '</option>';
            });
            $('#eventTypeId').html(options);
            $('#editEventTypeId').html(options);

            if (selectedEventTypeId) {
                $('#editEventTypeId').val(selectedEventTypeId);
            }
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

// Show register event type modal
$('.registerEventTypeModal').on('click', function() {
    $('#registerEventTypeModal').modal('show');
});

// Handle new event type registration form submission
$('#registerEventTypeForm').on('submit', function(event) {
    event.preventDefault();
    $.ajax({
        url: 'controller/ajax/ajax.forms.php',
        method: 'POST',
        data: $('#registerEventTypeForm').serialize(),
        success: function(response) {
            $('#eventTypesTable').DataTable().ajax.reload();
        }
    });
});

function areaEncargada() {
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/ajax.forms.php',
        data: { search: 'areas' },
        dataType: 'json',
        success: function(response) {
            var select = $('#areaEncargada');
            var editAreaEncargada = $('#editAreaEncargada');
            select.empty();
            select.append('<option value="">Seleccione un área</option>');
            editAreaEncargada.empty();
            editAreaEncargada.append('<option value="">Seleccione un área</option>');
            for (var i = 0; i < response.length; i++) {
                select.append(`<option value="${response[i].idArea}">${response[i].nameArea}</option>`);
                editAreaEncargada.append(`<option value="${response[i].idArea}">${response[i].nameArea}</option>`);
            }
        }
    });
}

function deleteTypeEvent(idEventType) {
    if (confirm('¿Estás seguro de que quieres eliminar este tipo de evento?')) {
        $.ajax({
            url: 'controller/ajax/ajax.forms.php',
            method: 'POST',
            data: { 
                search: 'event_types',
                deleteEventType: idEventType 
            },
            success: function(response) {
                $('#eventTypesTable').DataTable().ajax.reload();
            }
        });
    }
}

$('#editEventTypeForm').on('submit', function(event) {
    event.preventDefault();
    $.ajax({
        url: 'controller/ajax/ajax.forms.php',
        method: 'POST',
        data: $('#editEventTypeForm').serialize(),
        success: function(response) {
            toggleForms();
            $('#eventTypesTable').DataTable().ajax.reload();
        }
    });
});

function editTypeEvent(idEventType, name, idArea, pointsPerEvent, benefitsPerYear) {
    $('#editEventType').val(idEventType);
    $('#editEventTypeName').val(name);
    $('#editAreaEncargada').val(idArea);
    $('#editEventTypePoints').val(pointsPerEvent);
    $('#editEventTypeBenefits').val(benefitsPerYear);
    toggleForms();
}

function cancelEditEventType() {
    $('#editEventTypeForm')[0].reset();
    toggleForms();
}

function toggleForms() {
    $('#registerEventTypeForm').toggleClass('d-none');
    $('#editEventTypeForm').toggleClass('d-none');
}

$('#eventTypeId').on('change', function() {
    var eventTypeId = $('#eventTypeId').val();
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/ajax.forms.php',
        data: { search: 'event_types', eventType: eventTypeId },
        dataType: 'json',
        success: function(response) {
            $('#points').val(response.pointsPerEvent);
        }
    });
});

$('#editEventTypeId').on('change', function() {
    var editEventTypeId = $('#editEventTypeId').val();
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/ajax.forms.php',
        data: { search: 'event_types', eventType: editEventTypeId },
        dataType: 'json',
        success: function(response) {
            $('#editPoints').val(response.pointsPerEvent);
        }
    });
});

function getUsers() {
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/ajax.forms.php',
        data: { search: 'users' },
        dataType: 'json',
        success: function(response) {
            var select = $('#eventUser');
            select.append( '<option vlaue="">Selecciona al encargado</option>' );
            for (var i = 0; i < response.length; i++) {
                select.append(`<option value="${response[i].id}">${response[i].firstname} ${response[i].lastname}</option>`);
            }
        }
    });
}