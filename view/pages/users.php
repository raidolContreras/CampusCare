<div class="container">
    <h2>Usuarios Registrados</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#registerUserModal">Registrar Usuario Nuevo</button>
    <div class="table-responsive">
        <table id="usersTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Correo Electrónico</th>
                    <th>Rol</th>
                    <th>Fecha de Registro</th>
                    <th>Acciones</th>
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
                        <label for="firstname" class="form-label">Nombre (s)</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" required>
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
                            <option value="teacher">Maestro</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar usuario -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="editUserId" name="id">
                    <div class="mb-3">
                        <label for="editFirstname" class="form-label">Nombre (s)</label>
                        <input type="text" class="form-control" id="editFirstname" name="firstname" required>
                    </div>
                    <div class="mb-3">
                        <label for="editLastname" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="editLastname" name="lastname" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="editRole" class="form-label">Rol</label>
                        <select class="form-control" id="editRole" name="role" required>
                            <option value="teacher">Maestro</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="view/assets/js/ajax/users.js"></script>
