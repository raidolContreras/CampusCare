
$(document).ready(function() {
    // Inicializar DataTable
    var table = $('#usersTable').DataTable({
        ajax: {
            url: "controller/ajax/ajax.getUsers.php",
            dataSrc: ''
        },
        columns: [
            { "data": "id" },
            { "data": "firstname" },
            { "data": "lastname" },
            { "data": "email" },
            { "data": "role" },
            { "data": "created_at" },
            {
                "data": null,
                "render": function (data, type, row) {
                    return `
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Acciones
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="#" onclick="editUser(${data.id})">Editar</a></li>
                                <li><a class="dropdown-item" href="#" onclick="deleteUser(${data.id})">Eliminar</a></li>
                            </ul>
                        </div>`;
                }
            }
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
                    table.ajax.reload();
                }
            }
        });
    });

    // Manejar el envío del formulario de edición
    $('#editUserForm').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: 'controller/ajax/ajax.updateUser.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert(response);
                if (response === 'success') {
                    $('#editUserForm')[0].reset();
                    $('#editUserModal').modal('hide');
                    table.ajax.reload();
                }
            }
        });
    });
});

function editUser(id) {
    $.ajax({
        url: 'controller/ajax/ajax.getUser.php',
        method: 'GET',
        data: { id: id },
        success: function(response) {
            var user = JSON.parse(response);
            $('#editUserId').val(user.id);
            $('#editFirstname').val(user.firstname);
            $('#editLastname').val(user.lastname);
            $('#editEmail').val(user.email);
            $('#editRole').val(user.role);
            $('#editUserModal').modal('show');
        }
    });
}

function deleteUser(id) {
    if (confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
        $.ajax({
            url: 'controller/ajax/ajax.deleteUser.php',
            method: 'POST',
            data: { id: id },
            success: function(response) {
                alert(response);
                if (response === 'success') {
                    table.ajax.reload();
                }
            }
        });
    }
}