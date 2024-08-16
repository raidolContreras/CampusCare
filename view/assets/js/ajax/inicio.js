$(document).ready(function() {
    // Cuando el documento esté listo, llama a la función eventCards para cargar los eventos.
    eventCards();
    var idStudent = $('#idStudent').val();

    if (idStudent) {
        loadStudentDashboard(idStudent);
    } else {
        console.log("El idStudent no existe.");
    }

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

async function eventCards() {
    // Función para cargar y mostrar las tarjetas de eventos.

    const role = $('#role').val(); // Obtiene el rol del usuario (admin, student, etc.).
    const idStudent = $('#idStudent').val(); // Obtiene el ID del estudiante si aplica.

    $.ajax({
        // Realiza una petición AJAX para obtener los datos de los eventos.
        url: 'controller/ajax/eventCards.php',
        type: 'POST',
        dataType: 'json',
        success: async function(response) {
            let eventsHtml = ''; // Variable para almacenar el HTML generado para las tarjetas de eventos.
            let i = 0;
            for (const event of response) {
                i++;
                let actionHtml = '';

                if (role === 'student') {
                    // Si el rol es 'student', verifica si el estudiante ya está postulado al evento.
                    const isApplied = await checkApplicationStatus(idStudent, event.idEvent);

                    actionHtml = isApplied 
                        ? `<button class="btn btn-primary mt-auto" disabled>Ya postulado</button>` 
                        : `<button onclick="applyEvent(${event.idEvent})" class="btn btn-primary mt-auto">Postularme</button>`;
                    
                } else if (role === 'admin') {
                    // Si el rol es 'admin', agrega botones para editar y borrar el evento.
                    actionHtml = `
                        <div class="btn-group" role="group" aria-label="Acciones">
                            <button onclick="editEvent(${event.idEvent})" class="btn btn-primary mt-auto">Editar evento</button> 
                            <button onclick="deleteEvent(${event.idEvent})" class="btn btn-danger mt-auto">Borrar evento</button>
                        </div>`;
                } else {
                    // Si el rol es otro (por ejemplo, un usuario regular), agrega un botón para ver el evento.
                    actionHtml = `
                        <div class="btn-group" role="group" aria-label="Acciones">
                            <button onclick="lookEvent(${event.idEvent})" class="btn btn-primary mt-auto">Ver evento</button>
                            <button onclick="lookCandidates(${event.idEvent})" class="btn btn-info mt-auto">Ver candidatos</button>
                        </div>`;
                }

                // Construye la tarjeta de evento y espera a que se resuelva.
                const html = await buildEventCard(event, actionHtml);
                eventsHtml += html; // Acumula el HTML generado.
            }

            if (i == 0) {
                eventsHtml = `<div class="col-lg-12 mb-4">
                                    <div class="card shadow-sm h-100 border-0 rounded-lg">
                                        <div class="card-body d-flex flex-column">
                                        <p class="card-text text-muted">
                                            Sin eventos disponibles
                                        </p>
                                        </div>
                                    </div>
                                </div>
                                `;
            }

            // Una vez que se han generado todas las tarjetas, actualiza el HTML.
            updateEventsHtml(eventsHtml);
        }
    });
}


function getStudentsEvent(idEvent) {
    return $.ajax({
        url: 'controller/ajax/ajax.forms.php',
        method: 'POST',
        data: { idEvent: idEvent, search: 'event', action: 'studentEvents'},
        dataType: 'json'
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

async function buildEventCard(event, actionHtml) {
    // Función para construir el HTML de una tarjeta de evento.
    const eventDateTime = new Date(`${event.date} ${event.start_time}`);
    const currentDateTime = new Date();

    // Verifica si la fecha del evento ya pasó
    if (eventDateTime < currentDateTime) {
        return ''; // Si la fecha ya pasó, no retorna nada
    }

    const formattedDateTime = formatDateTime(eventDateTime); // Formatea la fecha y hora del evento.
    let counter = 0;
    // Espera a que se resuelva la promesa para obtener el conteo de estudiantes.
    const count = await getStudentsEvent(event.idEvent);
    
    counter = (count.students != null) ? count.students : 0;
    const vacanciesAvailable = event.vacancies_available - counter;

    let role = $('#role').val();
    let idUser = $('#idUser').val();

    // Condiciones para la construcción de la tarjeta de evento
    if (idUser == event.idUser && role == 'teacher') {
        return `
        <div class="col-lg-4 col-sm-6 col-12 mb-4">
            <div class="card shadow-sm h-100 border-0 rounded-lg">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-primary font-weight-bold mb-3">${event.name}</h5>
                    <p class="card-text text-muted"><i class="fas fa-map-marker-alt"></i> <strong>Lugar:</strong> ${event.location}</p>
                    <p class="card-text mb-3 text-secondary">${event.description}</p>
                    <hr class="my-3">
                    <p class="card-text mb-2"><i class="fas fa-calendar-alt"></i> <strong>Fecha:</strong> ${formattedDateTime}</p>
                    <p class="card-text mb-3"><i class="fas fa-users"></i> <strong>Vacantes disponibles:</strong> ${vacanciesAvailable}</p>
                    ${actionHtml}
                </div>
            </div>
        </div>`;
    } else if (role != 'teacher') {
        if (role == 'student' && vacanciesAvailable <= 0 && actionHtml != '<button class="btn btn-primary mt-auto" disabled>Ya postulado</button>') {
            return '';
        } else {
            return `
            <div class="col-lg-4 col-sm-6 col-12 mb-4">
                <div class="card shadow-sm h-100 border-0 rounded-lg">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-primary font-weight-bold mb-3">${event.name}</h5>
                        <p class="card-text text-muted"><i class="fas fa-map-marker-alt"></i> <strong>Lugar:</strong> ${event.location}</p>
                        <p class="card-text mb-3 text-secondary">${event.description}</p>
                        <hr class="my-3">
                        <p class="card-text mb-2"><i class="fas fa-calendar-alt"></i> <strong>Fecha:</strong> ${formattedDateTime}</p>
                        <p class="card-text mb-3"><i class="fas fa-users"></i> <strong>Vacantes disponibles:</strong> ${vacanciesAvailable}</p>
                        ${actionHtml}
                    </div>
                </div>
            </div>`;
        }
    } else {
        return '';
    }
}

function updateEventsHtml(htmlContent) {
    // Función para actualizar el HTML de la lista de eventos.

    $('.events').html(htmlContent); // Inserta el contenido HTML en el contenedor de eventos.
}

function applyEvent(idEvent) {
    // Mostrar el modal de confirmación primero
    $('#applyEventModal .modal-body').html('<p>¿Estás seguro de que deseas registrarte a este evento?</p>');
    
    // Configurar el botón de confirmación para ejecutar la solicitud AJAX
    $('#applyEventModal .btn-primary').off('click').on('click', function() {
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

                eventCards(); // Recarga la lista de eventos para reflejar el estado actualizado.
                $('#applyEventModal').modal('hide');

            }
        });
    });

    $('#applyEventModal').modal('show'); // Muestra el modal para confirmar.
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

function lookEvent(event) {
    
}

function lookCandidates(event) {
    $.ajax({
        url: 'controller/ajax/ajax.forms.php',
        method: 'POST',
        data: { idEvent: event, search: 'event', action: 'lookCandidates' },
        dataType: 'json',
        success: function(students) {
            // Limpiar la tabla antes de llenarla
            $('#candidatesTable tbody').empty();
            let user = $('#idUser').val();
            // Iterar sobre los datos recibidos y agregar filas a la tabla
            $.each(students, function(index, student) {
                let button = '';
                if (student.status == 1) {
                    button = `
                                <button class="btn btn-primary" onclick="aprobar(1,${event}, ${student.idStudent}, ${user})">Aprobar evento</button>
                                <button class="btn btn-danger" onclick="aprobar(0,${event}, ${student.idStudent}, ${user})">Rechazar evento</button>
                            `;
                } else if (student.status == 2) {
                    button = `
                                <button class="btn btn-primary" disabled>Aprobado</button>
                            `;
                } else if (student.status == 3) {
                    button = `
                                <button class="btn btn-primary" disabled>Rechazado</button>
                            `;
                } else {
                    button = `
                                <button class="btn btn-primary" onclick="accept(1,${event}, ${student.idStudent}, ${user})">Aceptar</button>
                                <button class="btn btn-danger" onclick="accept(0,${event}, ${student.idStudent}, ${user})">Rechazar</button>
                            `;
                }
                var row = '<tr>' +
                          '<td>' + (index + 1) + '</td>' +
                          '<td>' + student.firstname + '</td>' +
                          '<td>' + student.lastname + '</td>' +
                          '<td>' + student.email + '</td>' +
                          '<td>' + student.phone + '</td>' +
                          `<td>
                            <div class="btn-group">
                                ${button}
                            </div>
                          </td>` +
                          '</tr>';
                $('#candidatesTable tbody').append(row);
            });

            // Mostrar el modal
            $('#candidatesModal').modal('show');
        }
    });
}

function accept(status, event, student, user) {
    $.ajax({
        url: 'controller/ajax/ajax.forms.php',
        method: 'POST',
        data: { idEvent: event, idStudent: student, idUser: user, status: status, action: 'acceptCandidate', search: 'event' },
        success: function(response) {
            $('#candidatesModal').modal('hide');
            lookCandidates(event);
        }
    });
}

function aprobar(status, event, student, user) {
    $.ajax({
        url: 'controller/ajax/ajax.forms.php',
        method: 'POST',
        data: { idEvent: event, idStudent: student, idUser: user, status: status, action: 'approveEvent', search: 'event' },
        success: function(response) {
            $('#candidatesModal').modal('hide');
            lookCandidates(event);
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

function loadStudentDashboard(student) {
    let eventList = $('#eventList');
    let totalPoints = 0;
    let minPoints = 0;

    $.ajax({
        url: 'controller/ajax/ajax.forms.php',
        type: 'POST',
        data: { search: 'studentEvents', idStudent: student },
        dataType: 'json',
        success: function(response) {
            eventList.empty(); // Limpia el contenido previo

            if (response && response.length > 0) {
                response.forEach(data => {
                    const listItem = $(`
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="row">
                                <span class="col-10">${data.eventName}</span>
                                <span class="badge bg-primary rounded-pill col-2">${data.points} puntos</span>
                            </div>
                        </li>
                    `);
                    eventList.append(listItem);
                    totalPoints += data.points;
                    minPoints = data.minPoints;
                });

                $('#totalPoints').html(`<strong>${totalPoints}</strong> / ${minPoints} puntos`);

                if (totalPoints >= minPoints) {
                    showAchievementModal();
                }
            } else {
                eventList.html('<li class="list-group-item text-muted">No se encontraron eventos.</li>');
            }
        },
        error: function() {
            eventList.html('<li class="list-group-item text-danger">Error al cargar los eventos.</li>');
        }
    });

    function showAchievementModal() {
        $('#achievementModalLabel').text('¡Felicidades!');
        $('#achievementModalBody').html(`
            <p>Has alcanzado el 100% de puntos. ¡Excelente trabajo!</p>
            <div class="d-grid gap-2">
                <button type="button" class="btn btn-success">Iniciar trámites de finalización</button>
            </div>
        `);
        $('#achievementModal').modal('show');
    }
}
