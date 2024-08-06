<div class="container">
    <h2>Estudiantes Registrados</h2>
    <button class="btn btn-primary mb-3 registerStudentModal">Registrar Estudiante Nuevo</button>
    <div class="table-responsive">
        <table id="studentsTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Matricula</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Licenciatura</th>
                    <th>Pariente</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<?php
    include 'view/pages/modals/studentModals.php';
?>
<script src="view/assets/js/ajax/students.js"></script>