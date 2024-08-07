$(document).ready(function() {
    // Cuando el documento esté listo, llama a la función eventCards para cargar los eventos.
    eventCards();
});

function formatDateTime(dateTimeString) {
    // Función para formatear una fecha y hora dada en un formato más legible.

    const months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    
    const date = new Date(dateTimeString); // Convierte la cadena de fecha y hora en un objeto Date.
    const day = date.getDate(); // Obtiene el día del mes.
    const month = months[date.getMonth()]; // Obtiene el mes y lo convierte a texto.
    const year = date.getFullYear(); // Obtiene el año.
    
    let hours = date.getHours(); // Obtiene la hora.
    const minutes = date.getMinutes(); // Obtiene los minutos.
    const ampm = hours >= 12 ? 'PM' : 'AM'; // Determina si es AM o PM.
    
    hours = hours % 12 || 12; // Convierte la hora al formato de 12 horas y ajusta para que 0 sea 12.
    
    const minutesFormatted = minutes < 10 ? '0' + minutes : minutes; // Formatea los minutos para que siempre tengan dos dígitos.

    return `${day} de ${month} del ${year}, ${hours}:${minutesFormatted} ${ampm}`; // Devuelve la fecha y hora formateada.
}

function eventCards() {
    // Función para cargar y mostrar las tarjetas de eventos.

    const role = $('#role').val(); // Obtiene el rol del usuario (admin, student, etc.).
    const idStudent = $('#idStudent').val(); // Obtiene el ID del estudiante si aplica.

    $.ajax({
        // Realiza una petición AJAX para obtener los datos de los eventos.
        url: 'controller/ajax/eventCards.php',
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            let eventsHtml = ''; // Variable para almacenar el HTML generado para las tarjetas de eventos.
            const promises = []; // Arreglo para almacenar las promesas si el rol es 'student'.

            response.forEach(function(event) {
                // Itera sobre cada evento en la respuesta.

                if (role === 'student') {
                    // Si el rol es 'student', verifica si el estudiante ya está postulado al evento.

                    const promise = checkApplicationStatus(idStudent, event.idEvent).then(isApplied => {
                        // Llama a la función checkApplicationStatus y maneja la respuesta.

                        const actionHtml = isApplied 
                            ? `<button class="btn btn-primary mt-auto" disabled>Ya postulado</button>` 
                            : `<button onclick="applyEvent(${event.idEvent})" class="btn btn-primary mt-auto">Postularme</button>`;
                        
                        eventsHtml += buildEventCard(event, actionHtml); // Construye el HTML de la tarjeta con la acción correspondiente.
                    });

                    promises.push(promise); // Agrega la promesa al arreglo de promesas.
                } else {
                    // Si el rol no es 'student', determina las acciones disponibles según el rol.

                    let actionHtml = '';
                    if (role === 'admin') {
                        // Si el rol es 'admin', agrega botones para editar y borrar el evento.
                        actionHtml = `
                            <div class="btn-group" role="group" aria-label="Acciones">
                                <button onclick="editEvent(${event.idEvent})" class="btn btn-primary mt-auto">Editar evento</button> 
                                <button onclick="deleteEvent(${event.idEvent})" class="btn btn-danger mt-auto">Borrar evento</button>
                            </div>`;
                    } else {
                        // Si el rol es otro (por ejemplo, un usuario regular), agrega un botón para ver el evento.
                        actionHtml = `<button onclick="lookEvent(${event.idEvent})" class="btn btn-primary mt-auto">Ver evento</button>`;
                    }
                    eventsHtml += buildEventCard(event, actionHtml); // Construye el HTML de la tarjeta con la acción correspondiente.
                }
            });

            if (role === 'student') {
                // Si el rol es 'student', espera a que todas las promesas se resuelvan antes de actualizar el HTML.
                Promise.all(promises).then(() => updateEventsHtml(eventsHtml));
            } else {
                // Si el rol no es 'student', actualiza el HTML directamente.
                updateEventsHtml(eventsHtml);
            }
        }
    });
}

function checkApplicationStatus(idStudent, idEvent) {
    // Función para verificar si un estudiante ya está postulado a un evento.

    return $.ajax({
        url: 'controller/ajax/ajax.forms.php',
        type: 'POST',
        data: {
            search: 'event',
            action: 'checkApplication',
            idStudent: idStudent,
            idEvent: idEvent
        },
        dataType: 'json'
    });
}

function buildEventCard(event, actionHtml) {
    // Función para construir el HTML de una tarjeta de evento.

    const formattedDateTime = formatDateTime(`${event.date} ${event.start_time}`); // Formatea la fecha y hora del evento.

    // Devuelve el HTML de la tarjeta de evento con los detalles y la acción correspondiente.
    return `
        <div class="col-lg-4 col-sm-6 col-12 mb-4">
            <div class="card shadow-sm h-100 border-0 rounded-lg">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-primary font-weight-bold mb-3">${event.name}</h5>
                    <p class="card-text text-muted"><i class="fas fa-map-marker-alt"></i> <strong>Lugar:</strong> ${event.location}</p>
                    <p class="card-text mb-3 text-secondary">${event.description}</p>
                    <hr class="my-3">
                    <p class="card-text mb-2"><i class="fas fa-calendar-alt"></i> <strong>Fecha:</strong> ${formattedDateTime}</p>
                    <p class="card-text mb-3"><i class="fas fa-users"></i> <strong>Vacantes:</strong> ${event.vacancies_available}</p>
                    ${actionHtml}
                </div>
            </div>
        </div>`;
}

function updateEventsHtml(htmlContent) {
    // Función para actualizar el HTML de la lista de eventos.

    $('.events').html(htmlContent); // Inserta el contenido HTML en el contenedor de eventos.
}

function applyEvent(idEvent) {
    // Función para postularse a un evento.

    const idStudent = $('#idStudent').val(); // Obtiene el ID del estudiante.

    $.ajax({
        url: 'controller/ajax/ajax.forms.php',
        type: 'POST',
        data: { idEvent: idEvent, search: 'event', idStudent: idStudent, action: 'applyEvent'},
        success: function(response) {
            // Maneja la respuesta del servidor después de intentar postularse al evento.

            $('#applyEventModal .modal-body').html(response 
                ? '<p>Te has postulado exitosamente al evento.</p>' 
                : '<p>Hubo un problema al postularte. Intenta de nuevo.</p>'
            );
            $('#applyEventModal').modal('show'); // Muestra un modal con el resultado.

            eventCards(); // Recarga la lista de eventos para reflejar el estado actualizado.
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

$('#editEventForm').on('submit', function(event) {
    event.preventDefault();
    $.ajax({
        url: 'controller/ajax/ajax.updateEvent.php',
        method: 'POST',
        data: $('#editEventForm').serialize(),
        success: function(response) {
            $('#editEventModal').modal('hide');
            eventCards();
        }
    });
});

    // Handle editing form submission
    $('#editEventForm').on('submit', function(event) {
        handleFormSubmission(event, table, 'controller/ajax/ajax.updateEvent.php', '#editEventForm', '#');
    });

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
    // Función para borrar un evento.

    $('#deleteEventModal').modal('show'); // Muestra un modal para confirmar la eliminación.

    $('#deleteEventModal .btn-danger').off('click').on('click', function() {
        // Maneja la acción de confirmación cuando se hace clic en el botón de eliminar.
        $.ajax({
            url: 'controller/ajax/ajax.deleteEvent.php',
            method: 'POST',
            data: { idEvent: idEvent },
            success: function(response) {
                $('#deleteEventModal').modal('hide');
                eventCards(); // Recarga la lista de eventos.
            }
        });
        
    });
}
