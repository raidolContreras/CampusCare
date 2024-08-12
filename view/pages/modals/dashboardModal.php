<!-- Modal para aplicar al evento -->
<div class="modal fade" id="applyEventModal" tabindex="-1" role="dialog" aria-labelledby="applyEventModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="applyEventModalLabel">Postularme al Evento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Contenido del modal para aplicar al evento -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Confirmar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para editar evento -->
<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="editEventModalLabel">Editar Evento</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editEventForm">
                    <input type="hidden" id="editEventId" name="idEvent">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editEventTypeId" class="form-label">Tipo de Evento</label>
                            <select name="editEventTypeId" id="editEventTypeId" class="form-select" required>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editEventName" class="form-label">Nombre del Evento</label>
                            <input type="text" class="form-control" id="editEventName" name="eventName" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editDate" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="editDate" name="date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editLocation" class="form-label">Ubicación</label>
                            <input type="text" class="form-control" id="editLocation" name="location" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editStartTime" class="form-label">Hora de Inicio</label>
                            <input type="time" class="form-control" id="editStartTime" name="start_time" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editEndTime" class="form-label">Hora de Fin</label>
                            <input type="time" class="form-control" id="editEndTime" name="end_time" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editPoints" class="form-label">Puntos</label>
                            <input type="number" class="form-control" id="editPoints" name="points" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editVacanciesAvailable" class="form-label">Vacantes Disponibles</label>
                            <input type="number" class="form-control" id="editVacanciesAvailable" name="vacancies_available" required>
                        </div>
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

<!-- Modal para borrar el evento -->
<div class="modal fade" id="deleteEventModal" tabindex="-1" role="dialog" aria-labelledby="deleteEventModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteEventModalLabel">Borrar Evento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        ¿Está seguro de que quiere borrar este evento? Esto no se puede deshacer.

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger">Borrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="candidatesModal" tabindex="-1" role="dialog" aria-labelledby="candidatesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="candidatesModalLabel">Lista de Candidatos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Aquí se mostrará la lista de candidatos -->
         <table class="table table-striped" id="candidatesTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo Electrónico</th>
                    <th>Teléfono</th>
                    <th></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>