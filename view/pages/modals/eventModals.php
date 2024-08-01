
<!-- Modal para registrar tipo de evento nuevo -->
<div class="modal fade" id="registerEventTypeModal" tabindex="-1" aria-labelledby="registerEventTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="registerEventTypeModalLabel">Tipos de eventos</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-3">
                        <!-- Formulario para registrar nuevo tipo de evento -->
                        <form id="registerEventTypeForm">
                            <div class="mb-3">
                                <label for="eventTypeName" class="form-label">Nombre del Tipo de Evento</label>
                                <input type="text" class="form-control" id="eventTypeName" name="eventTypeName" required>
                            </div>
                            <div class="mb-3">
                                <label for="areaEncargada" class="form-label">Area encargada</label>
                                <select name="areaEncargada" id="areaEncargada" class="form-select">
                                    <option value="">Seleccione una opción</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="eventTypePoints" class="form-label">Puntos por Evento</label>
                                <input type="number" class="form-control" id="eventTypePoints" name="eventTypePoints" required>
                            </div>
                            <div class="mb-3">
                                <label for="eventTypeBenefits" class="form-label">Beneficios por Año</label>
                                <input type="number" class="form-control" id="eventTypeBenefits" name="eventTypeBenefits" required>
                                <input type="hidden" name="search" value="event_types">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                            </div>
                        </form>

                        <!-- Formulario para editar tipo de evento -->
                        <form id="editEventTypeForm" class="d-none">
                            <div class="mb-3">
                                <label for="editEventTypeName" class="form-label">Nombre del Tipo de Evento</label>
                                <input type="text" class="form-control" id="editEventTypeName" name="editEventTypeName" required>
                            </div>
                            <div class="mb-3">
                                <label for="editAreaEncargada" class="form-label">Area encargada</label>
                                <select name="editAreaEncargada" id="editAreaEncargada" class="form-select">
                                    <option value="">Seleccione una opción</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editEventTypePoints" class="form-label">Puntos por Evento</label>
                                <input type="number" class="form-control" id="editEventTypePoints" name="editEventTypePoints" required>
                            </div>
                            <div class="mb-3">
                                <label for="editEventTypeBenefits" class="form-label">Beneficios por Año</label>
                                <input type="number" class="form-control" id="editEventTypeBenefits" name="editEventTypeBenefits" required>
                                <input type="hidden" id="editEventType" name="editEventType">
                                <input type="hidden" id="event_types" name="search" value="event_types">
                            </div>
                            <center>
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                                    <button type="button" class="btn btn-danger" onclick="cancelEditEventType()">Cancelar</button>
                                </div>
                            </center>
                        </form>
                    </div>
                    <div class="col-9">
                        <table id="eventTypesTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="40%">Nombre del Tipo de Evento</th>
                                    <th width="20%">Area encargada</th>
                                    <th width="10%">Puntos por Evento</th>
                                    <th width="10%">Beneficios por Año</th>
                                    <th width="10%">Acciones</th>
                                </tr>
                            </thead>
                        </table>
    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para registrar evento nuevo -->
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
                            <select name="eventTypeId" id="eventTypeId" class="form-select" required>
                            </select>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="editEventModalLabel">Editar Evento</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
