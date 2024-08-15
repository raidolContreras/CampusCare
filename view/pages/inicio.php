<style>

    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .card-body .btn-group {
        margin-top: auto;
    }

    /* Título del tablero */
    #namePage {
        font-size: 1.75rem;
        font-weight: bold;
        margin-bottom: 20px;
        text-align: center;
    }

    /* Destacar la sección de eventos */
    #eventList {
        max-height: 300px;
        overflow-y: auto;
    }

    .list-group-item {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        margin-bottom: 5px;
    }

    /* Adaptar mejor los tamaños */
    .col-md-2, .col-md-5 {
        margin-bottom: 20px;
    }

    /* Color destacado para el total de puntos */
    #totalPoints {
        font-size: 1.5rem;
        font-weight: bold;
        color: #01643d;
    }

    /* Ocultar scrollbar */
    #eventList::-webkit-scrollbar {
        display: none;
    }

    #eventList {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <strong id='namePage'>Tablero</strong>
        </div>
    </div>

    <div class="row">
        <?php if ($role == 'Estudiante'):?>

            <div class="col-md-8 row" style="justify-content: center;">

                <!-- Puntos totales -->
                <div class="card col-12">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Puntos Totales</h6>
                        <p class="card-text" id="totalPoints">0 puntos</p>
                    </div>
                </div>
                
                <!-- Sección adicional para eventos o contenido -->
                <div class="row mt-4 events col-12">
                    <!-- Aquí puedes añadir contenido adicional o dinámico -->
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Eventos Asistidos</h6>
                        <ul class="list-group" id="eventList">
                            <!-- Aquí se llenará la lista de eventos con JavaScript -->
                            <li class="list-group-item">No has asistido a ningún evento aún.</li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Sección adicional para eventos o contenido -->
            <div class="mt-4 events">
                <!-- Aquí puedes añadir contenido adicional o dinámico -->
            </div>
        <?php endif ?>
    </div>

</div>

<?php
    include 'view/pages/modals/dashboardModal.php';
?>
<script src="view/assets/js/ajax/inicio.js"></script>

<script>
</script>
