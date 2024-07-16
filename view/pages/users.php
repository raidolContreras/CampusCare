<div class="container">
        <h2>Usuarios Registrados</h2>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#registerUserModal">Registrar Usuario Nuevo</button>
        <div class="table-responsive">
            <table id="usersTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo Electrónico</th>
                        <th>Rol</th>
                        <th>Fecha de Registro</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal para registrar usuario nuevo -->
    <div class="modal fade" id="registerUserModal" tabindex="-1" aria-labelledby="registerUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerUserModalLabel">Registrar Usuario Nuevo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registerUserForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Rol</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="student">Alumno</option>
                                <option value="admin">Administrador</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            var table = $('#usersTable').DataTable({
                ajax: {
                    url: "controller/ajax/ajax.getUsers.php",
                    dataSrc: ''
                },
                columns:[
                    { "data": "id" },
                    { "data": "name" },
                    { "data": "email" },
                    { "data": "role" },
                    { "data": "created_at" }
                ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                }
            });

            // Manejar el envío del formulario de registro
            $('#registerUserForm').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    url: 'controller/ajax/ajax.forms.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response);
                        if (response === 'success') {
                            $('#registerUserForm')[0].reset();
                            $('#registerUserModal').modal('hide');
                            window.location.reload();
                        }
                    }
                });
            });
        });
    </script>