$(document).ready(function() {
    // Inicializar DataTable
    var table = $('#studentsTable').DataTable({
        ajax: {
            type: 'POST',
            url: "controller/ajax/ajax.forms.php",
            dataSrc: '',
            data: {
                search: 'student'
            },
            dataType: 'json'
        },
        columns: [
            { "data": null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { "data": "matricula" },
            { "data": null,
                render: function (data, type, row) {
                    return `${data.firstname} ${data.lastname}`;
                }
            },
            { "data": "email" },
            { "data": "phone" },
            { "data": "licenciatura" },
            { "data": null,
                render: function (data, type, row) {
                    return `${data.parent}: ${data.emergenci_phone}`;
                }
             },
            {
                "data": null,
                render: function (data, type, row) {
                    // Verificar si el estudiante ha sido aceptado
                    var acceptButton = data.accepted == 0 ? 
                        `<button type="button" class="btn btn-success" onclick="acceptStudent(${data.idStudent})"><i class="fad fa-check"></i></button>` : 
                        `<button type="button" class="btn btn-secondary" disabled><i class="fad fa-check"></i></button>`;
                    
                    return `
                        <div class="btn-group" role="group" aria-label="Acciones">
                            ${acceptButton}
                            <button type="button" class="btn btn-primary" onclick="editUser(${data.idStudent})"><i class="fad fa-edit"></i></button>
                            <button type="button" class="btn btn-danger" onclick="deleteUser(${data.idStudent})"><i class="fad fa-trash-alt"></i></button>
                        </div>`;
                }
            }
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        }
    });
});


function acceptStudent(id) {
    // Lógica para aceptar al estudiante con el ID proporcionado
    // Por ejemplo, podrías hacer una llamada AJAX para actualizar el estado del estudiante en el servidor
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/ajax.forms.php',
        data: {
            search: 'student',
            action: 'acceptStudent',
            idStudent: id
        },
        success: function(response) {
            // Manejar la respuesta del servidor
            alert('Estudiante aceptado exitosamente');
            // Recargar la tabla si es necesario
            $('#studentsTable').DataTable().ajax.reload();
        },
        error: function(error) {
            // Manejar el error
            alert('Error al aceptar el estudiante');
        }
    });
}

