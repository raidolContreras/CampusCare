$(document).ready(function() {
    eventCards();
});

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

// Uso dentro del AJAX success
function eventCards() {
    $.ajax({
        url: 'controller/ajax/eventCards.php',
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            var eventsHtml = '';
            response.forEach(function(event) {
                const formattedDateTime = formatDateTime(`${event.date} ${event.start_time}`);
                eventsHtml += `
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                    <div class="card shadow-sm h-100 border-0 rounded-lg">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-primary font-weight-bold mb-3">${event.name}</h5>
                            <p class="card-text text-muted"><i class="fas fa-map-marker-alt"></i> <strong>Lugar:</strong> ${event.location}</p>
                            <p class="card-text mb-3 text-secondary">${event.description}</p>
                            <hr class="my-3">
                            <p class="card-text mb-2"><i class="fas fa-calendar-alt"></i> <strong>Fecha:</strong> ${formattedDateTime}</p>
                            <p class="card-text mb-3"><i class="fas fa-users"></i> <strong>Vacantes:</strong> ${event.vacancies_available}</p>
                            <a href="&getEvent=${event.idEvent}" class="btn btn-primary mt-auto">Postularme</a>
                        </div>
                    </div>
                </div>
                `;
            });
            $('.events').html(eventsHtml);
        }
    });
}
