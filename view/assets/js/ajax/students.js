$(document).ready(function () {
    initializeLicenciatura();
    initializeDataTable();

    $('.registerStudentModal').on('click', function () {
        $('#registerStudentModal').modal('show');
    });

    initializeValidation();
});

function initializeDataTable() {
    var role = $('#role').val();
    var columns = [
        { "data": null,
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            "data": "matricula",
            render: function(data, type, row) {
                return `<button type="button" class="btn btn-info btn-block" onclick="showStudentModal(${row.idStudent})">${data}</button>`;
            }
        },
        { "data": null, render: (data) => `${data.firstname} ${data.lastname}` },
        { "data": "email" },
        { "data": "phone" },
        { "data": "nameDegree" },
        { "data": null, render: (data) => `${data.parent}: ${data.emergenci_phone}` }
    ];

    // Agregar la columna de acciones solo si el rol es admin
    if (role == 'admin') {
        columns.push({
            "data": null,
            render: function (data) {
                let buttons = '';
                if (data.status === 1) {
                    if (data.accepted == 0) {
                        buttons = `
                        <button type="button" class="btn btn-success" onclick="acceptStudent(${data.idStudent})">
                            <i class="fad fa-check"></i>
                        </button>
                        <button type="button" class="btn btn-danger" onclick="denegateStudent(${data.idStudent})">
                            <i class="fas fa-times"></i>
                        </button>`;
                    } else if (data.accepted == 1) {
                        buttons = `
                        <button type="button" class="btn btn-primary" onclick="showEditModal(${data.idStudent})">
                            <i class="fad fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger" onclick="confirmDeleteStudent(${data.idStudent})">
                            <i class="fad fa-trash-alt"></i>
                        </button>`;
                    }

                    return `<div class="btn-group" role="group">${buttons}</div>`;
                } else {
                    return `<button type="button" class="btn btn-info" onclick="showCommentsModal('${data.comments}')">
                                <i class="fad fa-comments"></i>
                            </button>`;
                }
            }
        });
    }

    $('#studentsTable').DataTable({
        ajax: {
            type: 'POST',
            url: "controller/ajax/ajax.forms.php",
            dataSrc: '',
            data: { search: 'student' },
            dataType: 'json'
        },
        columns: columns,
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        }
    });
}

function showStudentModal(idStudent) {
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/ajax.forms.php', // Crear este endpoint para obtener los detalles del alumno
        data: {search: 'student', idStudent: idStudent },
        dataType: 'json',
        success: function(data) {
            // Rellenar los datos del alumno en el modal
            $('#studentMatricula').text(data.matricula);
            $('#studentFullName').text(`${data.firstname} ${data.lastname}`);
            $('#studentEmail').text(data.email);
            $('#studentPhone').text(data.phone);
            $('#studentAddress').text(`${data.street} ${data.nInt} ${data.nExt}, ${data.colony}, CP: ${data.cp}`);
            $('#studentDegree').text(data.nameDegree);
            $('#studentBirthday').text(`${data.dayBirthday}/${data.monthBirthday}/${data.yearBirthday}`);
            $('#studentGender').text(data.gender === 1 ? 'Masculino' : 'Femenino');
            $('#studentParent').text(`${data.parent}: ${data.emergenci_phone}`);

            // Mostrar el modal
            $('#studentModal').modal('show');
        },
        error: function() {
            alert('Error al obtener los detalles del alumno.');
        }
    });
}

function initializeLicenciatura() {
    $.ajax({
        type: 'POST',
        url: "controller/ajax/ajax.forms.php",
        data: { search: 'degrees' },
        dataType: 'json',
        success: function (response) {
            let options = '<option value="">Seleccione licenciatura</option>';
            response.forEach(item => {
                options += `<option value="${item.idDegree}">${item.nameDegree}</option>`;
            });
            $('#licenciatura').html(options);
            $('#editLicenciatura').html(options);
        }
    });
}

function initializeValidation() {
    $('#matricula').on('input', function () {
        toggleValidation($(this), /^\d+$/);
    });

    $('#correoInstitucional').on('input', function () {
        toggleValidation($(this), /^[a-zA-Z0-9._%+-]+@unimontrer\.edu\.mx$/);
    });

    $('#telefonoContacto, #telefonoEmergencia').on('input', function () {
        toggleValidation($(this), /^\d{10}$/);
    });

    $('#registerStudentForm').on('submit', function (event) {
        event.preventDefault();
        if (validateForm()) {
            handleSubmitForm($(this));
        }
    });
}

function toggleValidation($element, regex) {
    $element.toggleClass('is-valid', regex.test($element.val()))
            .toggleClass('is-invalid', !regex.test($element.val()));
}

function validateForm() {
    let isValid = true;
    $('#matricula, #correoInstitucional, #telefonoContacto, #telefonoEmergencia').each(function () {
        if ($(this).hasClass('is-invalid')) {
            isValid = false;
        }
    });
    return isValid;
}

function handleSubmitForm($form) {
    const submitBtn = $('#submitBtn');
    submitBtn.prop('disabled', true).addClass('btn-loading').text('Enviando');

    let formData = $form.serializeArray();
    formData.push({ name: 'search', value: 'student' });
    formData.push({ name: 'action', value: 'addStudent' });

    $.post('controller/ajax/ajax.forms.php', formData, function (response) {
        submitBtn.prop('disabled', false).removeClass('btn-loading').text('Registrar');
        if (response === '"success"') {
            alert('Alumno registrado');
            $form[0].reset();
            $('#registerStudentModal').modal('hide');
            $('#studentsTable').DataTable().ajax.reload();
        } else if (response === '"duplicate"') {
            alert('Registro duplicado');
        } else {
            alert('Error al registrar alumno');
        }
    });
}

// Funciones adicionales para denegar, editar y eliminar estudiantes
function acceptStudent (id) {
    $.post('controller/ajax/ajax.forms.php', { search: 'student', action: 'acceptStudent', idStudent: id }, function (response) {
        alert('Estudiante aceptado');
        $('#studentsTable').DataTable().ajax.reload();
    }).fail(function () {
        alert('Error al aceptar al estudiante');
    });
}

function denegateStudent(id) {
    $.post('controller/ajax/ajax.forms.php', { search: 'student', action: 'denegateStudent', idStudent: id }, function (response) {
        alert('Estudiante denegado');
        $('#studentsTable').DataTable().ajax.reload();
    }).fail(function () {
        alert('Error al denegar el estudiante');
    });
}

function showEditModal(id) {
    // Obtener datos del estudiante y mostrarlos en el modal de edición
    $.post('controller/ajax/ajax.forms.php', { search: 'student', action: 'getStudent', idStudent: id }, function (data) {
        $('#editStudentModal #editMatricula').val(data.matricula);
        $('#editStudentModal #editNombre').val(data.firstname);
        $('#editStudentModal #editLastname').val(data.lastname);
        $('#editStudentModal #editCorreoInstitucional').val(data.email);
        $('#editStudentModal #editTelefonoContacto').val(data.phone);
        $('#editStudentModal #editTelefonoEmergencia').val(data.emergenci_phone);
        $('#editStudentModal #editParentesco').val(data.parent);
        $('#editStudentModal #editTipoLicenciatura').val(data.type_lic);
        $('#editStudentModal #editCalle').val(data.street);
        $('#editStudentModal #editNumeroInterior').val(data.nInt);
        $('#editStudentModal #editNumeroExterior').val(data.nExt);
        $('#editStudentModal #editColonia').val(data.colony);
        $('#editStudentModal #editCodigoPostal').val(data.cp);
        $('#editStudentModal #editDiaNacimiento').val(data.dayBirthday);
        $('#editStudentModal #editMesNacimiento').val(data.monthBirthday);
        $('#editStudentModal #editAnioNacimiento').val(data.yearBirthday);
        $('#editStudentModal #editGenero').val(data.gender);
        $('#editStudentModal #editLicenciatura').val(data.idDegree);
        $('#editStudentModal #editGrado').val(data.grado);
        $('#idStudent').val(id);

        $('#editStudentModal').data('idStudent', id).modal('show');
    }, 'json');
}

function showCommentsModal(comments) {
    $('#commentsModal #commentsContent').text(comments);
    $('#commentsModal').modal('show');
}

function confirmDeleteStudent(id) {
    $('#deleteStudentModal').data('idStudent', id).modal('show');
}

function deleteStudent() {
    let id = $('#deleteStudentModal').data('idStudent');
    let reason = $('#deleteReason').val();
    if (reason != '') {
        $.post('controller/ajax/ajax.forms.php', { search: 'student', action: 'dropStudent', idStudent: id, reason: reason }, function (response) {
            alert('Estudiante eliminado');

            // Recargar la tabla si es necesario
            $('#studentsTable').DataTable().ajax.reload();
            $('#deleteStudentModal').modal('hide');
            $('#deleteReason').val('');

        }).fail(function () {
            alert('Error al eliminar el estudiante');
        });
    } else {
        alert('Por favor, especifique el motivo de la eliminación');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Selectores del formulario de registro
    const diaSelect = document.getElementById('diaNacimiento');
    const mesSelect = document.getElementById('mesNacimiento');
    const anioSelect = document.getElementById('anioNacimiento');

    // Selectores del formulario de edición
    const editDiaSelect = document.getElementById('editDiaNacimiento');
    const editMesSelect = document.getElementById('editMesNacimiento');
    const editAnioSelect = document.getElementById('editAnioNacimiento');

    // Rellenar el selector de años
    const currentYear = new Date().getFullYear();
    function populateYearSelect(selectElement) {
        for (let year = currentYear; year >= 1900; year--) {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            selectElement.appendChild(option);
        }
    }
    
    // Llenar los años en ambos selectores
    if (anioSelect) populateYearSelect(anioSelect);
    if (editAnioSelect) populateYearSelect(editAnioSelect);

    // Función para actualizar los días según el mes y el año seleccionados
    function updateDays(selectElements) {
        const [yearSelect, monthSelect, daySelect] = selectElements;
        const selectedYear = parseInt(yearSelect.value);
        const selectedMonth = parseInt(monthSelect.value);

        // Limpiar el selector de días
        daySelect.innerHTML = '<option value="">Día</option>';

        if (!isNaN(selectedYear) && !isNaN(selectedMonth)) {
            const daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();
            for (let day = 1; day <= daysInMonth; day++) {
                const option = document.createElement('option');
                option.value = day;
                option.textContent = day;
                daySelect.appendChild(option);
            }
        }
    }

    // Añadir eventos a los selectores de mes y año para el formulario de registro
    if (mesSelect && anioSelect && diaSelect) {
        mesSelect.addEventListener('change', function() {
            updateDays([anioSelect, mesSelect, diaSelect]);
        });
        anioSelect.addEventListener('change', function() {
            updateDays([anioSelect, mesSelect, diaSelect]);
        });
    }

    // Añadir eventos a los selectores de mes y año para el formulario de edición
    if (editMesSelect && editAnioSelect && editDiaSelect) {
        editMesSelect.addEventListener('change', function() {
            updateDays([editAnioSelect, editMesSelect, editDiaSelect]);
        });
        editAnioSelect.addEventListener('change', function() {
            updateDays([editAnioSelect, editMesSelect, editDiaSelect]);
        });
    }
});

// Enviar el formulario de edición a través de AJAX
$('#editStudentForm').on('submit', function (event) {
    event.preventDefault();

    const submitBtn = $(this).find('button[type="submit"]');
    submitBtn.prop('disabled', true).addClass('btn-loading').text('Guardando...');

    $.ajax({
        url: 'controller/ajax/ajax.forms.php',
        method: 'POST',
        data: $(this).serialize() + '&action=editStudent&search=student',
        success: function (response) {
            submitBtn.prop('disabled', false).removeClass('btn-loading').text('Guardar');
            if (response === '"success"') {
                // Mostrar mensaje de éxito
                alert('Estudiante actualizado exitosamente');
                $('#editStudentModal').modal('hide');
                $('#studentsTable').DataTable().ajax.reload();
                $('#editStudentForm')[0].reset();
                $('#editStudentModal').data('idStudent', null);

            } else {
                // Mostrar mensaje de error
                alert('Error al actualizar el estudiante');
                
            }
        },
        error: function () {
            submitBtn.prop('disabled', false).removeClass('btn-loading').text('Guardar');
            alert('Ocurrió un error en la solicitud');
        }
    });
});