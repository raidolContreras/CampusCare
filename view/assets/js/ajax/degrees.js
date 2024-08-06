$(document).ready(function() {
    // Inicializar DataTable
    var table = $('#degreesTable').DataTable({
        ajax: {
            type: 'POST',
            url: "controller/ajax/ajax.forms.php",
            dataSrc: '',
            data: {
                search: 'degrees'
            },
            dataType: 'json'
        },
        columns: [
            { "data": null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { "data": "nameDegree" },
            { "data": "minPoints" },
            {
                "data": null,
                render: function (data, type, row) {
                    return `
                        <div class="btn-group" role="group" aria-label="Acciones">
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

$('.registerLicenciaturaModal').on('click', function() {
    $('#registerLicenciaturaModal').modal('show');
});

$('#licenciaturaForm').on('submit', function(event) {
    event.preventDefault();
    $.ajax({
        url: 'controller/ajax/ajax.forms.php',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            if (response === 'success') {
                alert('Nueva licenciatura creada');
                $('#licenciaturaForm')[0].reset();
                $('#degreesTable').DataTable().ajax.reload();
                $('#registerLicenciaturaModal').modal('hide');
            } else {
                alert('Error al crear la licenciatura');
            }
        }
    });
});