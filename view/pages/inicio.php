<style>
/* Estilo general */
body {
    font-family: 'Montserrat', sans-serif;
    color: #333;
    background-color: #f5f5f5;
    margin: 0;
    padding: 0;
}
/* Título del tablero */
#namePage {
    font-size: 1.25rem;
    text-transform: uppercase;
    letter-spacing: 0.05rem;
}

/* Tarjeta general */
.card {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    background-color: #fff;
    margin-bottom: 15px;
    padding: 15px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

/* Estilo de la tarjeta de puntos totales */
.card-body {
    padding: 10px;
    text-align: center;
}

.card-subtitle {
    font-size: 0.75rem;
    color: #888;
    margin-bottom: 5px;
}

#totalPoints {
    font-size: 1rem;
    font-weight: 600;
    color: #565656;
}

/* Sección de eventos asistidos */
.events-header {
    font-size: 0.875rem;
    font-weight: 500;
    color: #666;
    margin-bottom: 10px;
    text-align: center;
    border-bottom: 1px solid #eee;
    padding-bottom: 5px;
}

#eventList {
    max-height: 300px;
    overflow-y: auto;
    padding: 0;
    margin: 0;
    list-style: none;
}

.list-group-item {
    background-color: #fafafa !important;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    margin-bottom: 8px;
    padding: 10px;
    font-size: 0.75rem;
    color: #444;
    transition: background-color 0.3s ease;
}

.list-group-item:hover {
    background-color: #f0f0f0 !important;
}

/* Scrollbar personalizado */
#eventList::-webkit-scrollbar {
    width: 6px;
}

#eventList::-webkit-scrollbar-thumb {
    background-color: #c0c0c0;
    border-radius: 3px;
}

#eventList::-webkit-scrollbar-track {
    background-color: #f5f5f5;
}

/* Diseño responsivo */
@media (max-width: 768px) {
    #namePage {
        font-size: 1rem;
    }

    .card-subtitle {
        font-size: 0.625rem;
    }

    #totalPoints {
        font-size: 0.875rem;
    }

    .events-header {
        font-size: 0.75rem;
    }
}

</style>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <strong id='namePage'>Tablero de Eventos</strong>
        </div>
    </div>

    <div class="row float-right">
        <?php if ($role == 'Estudiante'):?>

            <div class="col-md-8">
                <!-- Puntos totales -->
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle">Puntos Totales</h6>
                        <p class="card-text" id="totalPoints">0 puntos</p>
                    </div>
                </div>

                <!-- Sección adicional para eventos o contenido -->
                <div class="mt-4 events row">
                    <!-- Aquí puedes añadir contenido adicional o dinámico -->
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="events-header">Eventos Asistidos</h6>
                        <ul class="list-group" id="eventList">
                            <!-- Aquí se llenará la lista de eventos con JavaScript -->
                            <li class="list-group-item">No has asistido a ningún evento aún.</li>
                        </ul>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <!-- Sección adicional para eventos o contenido -->
            <div class="mt-4 events row">
                <!-- Aquí puedes añadir contenido adicional o dinámico -->
            </div>
        <?php endif ?>
    </div>
</div>

<?php
    include 'view/pages/modals/dashboardModal.php';
?>
<script src="view/assets/js/ajax/inicio.js"></script>
