<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Estudiante</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 15px;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid #dee2e6;
        }

        .card:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            border-radius: 15px 15px 0 0 !important;
            background-color: #01643D;
            color: white;
            border-bottom: 1px solid #dee2e6;
            font-size: 1.8rem;
            font-weight: bold;
            padding: 20px;
        }

        .card-body {
            padding: 30px;
            background-color: white;
        }

        .btn-primary {
            margin-top: 1rem;
            border: none;
            font-size: 1.2rem;
            transition: background-color 0.2s ease-in-out, transform 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #01643D;
            transform: scale(1.05);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .form-control.is-valid {
            border-color: #28a745;
        }

        .invalid-feedback {
            display: none;
            color: #dc3545;
        }

        .valid-feedback {
            display: none;
            color: #28a745;
        }

        .form-control.is-invalid ~ .invalid-feedback {
            display: block;
        }

        .form-control.is-valid ~ .valid-feedback {
            display: block;
        }

        .form-control.is-invalid ~ .fas.fa-exclamation-circle {
            color: #dc3545;
            display: inline-block;
        }

        .form-control.is-valid ~ .fas.fa-check-circle {
            color: #28a745;
            display: inline-block;
        }

        .fas.fa-exclamation-circle,
        .fas.fa-check-circle {
            display: none;
            position: absolute;
            right: 10px;
            top: calc(50% - 10px);
        }

        .tooltip-inner {
            max-width: 200px;
            width: 200px;
        }

        .text-center img {
            margin-bottom: 20px;
        }

        .alert {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            padding: 15px;
            border: 1px solid transparent;
            border-radius: 10px;
            transition: all 0.5s ease-in-out;
            width: 300px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(-20px);
        }

        .alert-success {
            background-color: #e6f4ea;
            border-left: 5px solid #28a745;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-left: 5px solid #dc3545;
            color: #721c24;
        }

        .alert .close {
            position: absolute;
            top: 10px;
            right: 10px;
            color: inherit;
            background: none;
            border: none;
            font-size: 1.2rem;
        }

        .alert .alert-icon {
            font-size: 1.5rem;
            margin-right: 10px;
        }

        .alert-show {
            display: block !important;
            opacity: 1;
            transform: translateY(0);
        }

        .alert-hide {
            opacity: 0;
            transform: translateY(-20px);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="text-center">
            <img src="view/assets/images/logo-color.png" alt="Logo de Unimo" class="img-fluid" style="max-width: 10em;">
        </div>
        <div class="card">
            <div class="card-header text-center">
                Registro de Estudiante
            </div>
            <div class="card-body">
                <form id="registerStudentForm">
                    <div class="form-row">
                        <div class="col-md-6 form-group position-relative">
                            <label for="matricula" class="form-label">Matrícula <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="Ingresa tu matrícula de estudiante"></i></label>
                            <input type="text" class="form-control" id="matricula" name="matricula" placeholder="Ingresa tu matrícula" required>
                            <i class="fas fa-exclamation-circle"></i>
                            <i class="fas fa-check-circle"></i>
                            <div class="invalid-feedback">La matrícula debe contener solo números.</div>
                            <div class="valid-feedback">Matrícula válida.</div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 form-group">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Ingresa tus apellidos" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="licenciatura" class="form-label">Licenciatura</label>
                            <input type="text" class="form-control" id="licenciatura" name="licenciatura" placeholder="Ingresa tu licenciatura" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 form-group">
                            <label for="tipoLicenciatura" class="form-label">Tipo de Licenciatura</label>
                            <select class="form-control" id="tipoLicenciatura" name="tipoLicenciatura" required>
                                <option value="semestre">Semestre</option>
                                <option value="cuatrimestre">Cuatrimestre</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="grado" class="form-label">Grado</label>
                            <input type="number" class="form-control" id="grado" name="grado" placeholder="Ingresa tu grado" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 form-group position-relative">
                            <label for="correoInstitucional" class="form-label">Correo Institucional <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="Debe ser de la forma @unimontrer.edu.mx"></i></label>
                            <input type="email" class="form-control" id="correoInstitucional" name="correoInstitucional" placeholder="correo@unimontrer.edu.mx" required>
                            <i class="fas fa-exclamation-circle"></i>
                            <i class="fas fa-check-circle"></i>
                            <div class="invalid-feedback">El correo debe ser de la forma @unimontrer.edu.mx.</div>
                            <div class="valid-feedback">Correo válido.</div>
                        </div>
                        <div class="col-md-6 form-group position-relative">
                            <label for="telefonoContacto" class="form-label">Teléfono de Contacto <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="Debe contener 10 dígitos"></i></label>
                            <input type="tel" class="form-control" id="telefonoContacto" name="telefonoContacto" placeholder="Ingresa tu teléfono de contacto" required>
                            <i class="fas fa-exclamation-circle"></i>
                            <i class="fas fa-check-circle"></i>
                            <div class="invalid-feedback">El teléfono de contacto debe contener 10 dígitos.</div>
                            <div class="valid-feedback">Teléfono válido.</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 form-group position-relative">
                            <label for="telefonoEmergencia" class="form-label">Teléfono de Emergencia <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="Debe contener 10 dígitos"></i></label>
                            <input type="tel" class="form-control" id="telefonoEmergencia" name="telefonoEmergencia" placeholder="Ingresa tu teléfono de emergencia" required>
                            <i class="fas fa-exclamation-circle"></i>
                            <i class="fas fa-check-circle"></i>
                            <div class="invalid-feedback">El teléfono de emergencia debe contener 10 dígitos.</div>
                            <div class="valid-feedback">Teléfono válido.</div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="parentesco" class="form-label">Parentesco</label>
                            <input type="text" class="form-control" id="parentesco" name="parentesco" placeholder="Ingresa tu parentesco" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" id="submitBtn">Registrar</button>
                </form>
                <div class="alert alert-success mt-3 alert-hide" id="successMessage">
                    <button type="button" class="close" onclick="hideAlert('successMessage')">&times;</button>
                    <i class="fas fa-check-circle alert-icon"></i>
                    ¡Éxito!
                    <p>Se registraron tus datos de manera correcta</p>
                </div>
                <div class="alert alert-danger mt-3 alert-hide" id="errorMessage">
                    <button type="button" class="close" onclick="hideAlert('errorMessage')">&times;</button>
                    <i class="fas fa-times-circle alert-icon"></i>
                    Error
                    <p>No se puedo crear al alumno</p>
                </div>
                <div class="alert alert-warning mt-3 alert-hide" id="duplicateMessage">
                    <button type="button" class="close" onclick="hideAlert('duplicateMessage')">&times;</button>
                    <i class="fas fa-exclamation-circle alert-icon"></i>
                    Duplicado
                    <p>Alumno ya registrado en el sistema</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();

            const phoneRegex = /^\d{10}$/;
            const emailRegex = /^[a-zA-Z0-9._%+-]+@unimontrer\.edu\.mx$/;

            $('#matricula').on('input', function () {
                const matricula = $(this).val();
                if (!/^\d+$/.test(matricula)) {
                    $(this).addClass('is-invalid').removeClass('is-valid');
                } else {
                    $(this).addClass('is-valid').removeClass('is-invalid');
                }
            });

            $('#correoInstitucional').on('input', function () {
                const correoInstitucional = $(this).val();
                if (!emailRegex.test(correoInstitucional)) {
                    $(this).addClass('is-invalid').removeClass('is-valid');
                } else {
                    $(this).addClass('is-valid').removeClass('is-invalid');
                }
            });

            $('#telefonoContacto, #telefonoEmergencia').on('input', function () {
                const telefono = $(this).val();
                if (!phoneRegex.test(telefono)) {
                    $(this).addClass('is-invalid').removeClass('is-valid');
                } else {
                    $(this).addClass('is-valid').removeClass('is-invalid');
                }
            });

            $('#registerStudentForm').on('submit', function (event) {
                event.preventDefault();
                if (validateForm()) {
                    $('#successMessage').hide();
                    $('#errorMessage').hide();
                    $('#duplicateMessage').hide();
                    const submitBtn = $('#submitBtn');
                    submitBtn.prop('disabled', true).addClass('btn-loading').text('Enviando');

                    $.ajax({
                        url: 'controller/ajax/ajax.forms.php',
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function (response) {
                            submitBtn.prop('disabled', false).removeClass('btn-loading').text('Registrar');
                            if (response === 'success') {
                                showAlert('successMessage');
                            } else if (response === 'duplicate') {
                                showAlert('duplicateMessage');
                            } else {
                                showAlert('errorMessage');
                            }
                        }
                    });
                }
            });

            function validateForm() {
                let isValid = true;

                const matricula = $('#matricula').val();
                if (!/^\d+$/.test(matricula)) {
                    isValid = false;
                    $('#matricula').addClass('is-invalid').removeClass('is-valid');
                }

                const correoInstitucional = $('#correoInstitucional').val();
                if (!emailRegex.test(correoInstitucional)) {
                    isValid = false;
                    $('#correoInstitucional').addClass('is-invalid').removeClass('is-valid');
                }

                const telefonoContacto = $('#telefonoContacto').val();
                const telefonoEmergencia = $('#telefonoEmergencia').val();
                if (!phoneRegex.test(telefonoContacto) || !phoneRegex.test(telefonoEmergencia)) {
                    isValid = false;
                    if (!phoneRegex.test(telefonoContacto)) {
                        $('#telefonoContacto').addClass('is-invalid').removeClass('is-valid');
                    }
                    if (!phoneRegex.test(telefonoEmergencia)) {
                        $('#telefonoEmergencia').addClass('is-invalid').removeClass('is-valid');
                    }
                }

                return isValid;
            }

            function showAlert(messageId) {
                const alertElement = $('#' + messageId);
                alertElement.removeClass('alert-hide').addClass('alert-show');
                setTimeout(function () {
                    alertElement.addClass('alert-hide').removeClass('alert-show');
                }, 5000);
            }

            window.hideAlert = function(messageId) {
                $('#' + messageId).addClass('alert-hide').removeClass('alert-show');
            }
        });
    </script>
</body>

</html>
