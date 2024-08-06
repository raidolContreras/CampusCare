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

        .btn-primary:hover {
            color: #fff;
            background-color: #01643D; 
            border-color: #01643D;
        }

        .btn-primary:not(:disabled):not(.disabled).active, .btn-primary:not(:disabled):not(.disabled):active, .show>.btn-primary.dropdown-toggle {
            color: #fff;
            background-color: #1b4434;
            border-color: #01643D;
        }

        .btn-primary.focus, .btn-primary:focus {
            color: #fff;
            background-color: #01643D;
            border-color: #01643D;
            box-shadow: 0px 0px 17px 0px rgba(10,102,39,0.18);
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
            <div class="card-body"><form id="registerStudentForm">
    <div class="step" id="step-1">
        <h4>Paso 1: Información Personal</h4>
        <div class="form-row">
            <div class="col-md-6 form-group position-relative">
                <label for="matricula" class="form-label">Matrícula <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="Ingresa tu matrícula de estudiante"></i></label>
                <input type="text" class="form-control" id="matricula" name="matricula" placeholder="Ingresa tu matrícula" required>
                <div class="invalid-feedback">La matrícula debe contener solo números.</div>
                <div class="valid-feedback">Matrícula válida.</div>
            </div>
            <div class="col-md-6 form-group">
                <label for="nombre" class="form-label">Nombre *</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="apellidoPaterno" class="form-label">Apellido paterno *</label>
                <input type="text" class="form-control" id="apellidoPaterno" name="apellidoPaterno" placeholder="Ingresa tu apellido paterno" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="apellidoMaterno" class="form-label">Apellido materno</label>
                <input type="text" class="form-control" id="apellidoMaterno" name="apellidoMaterno" placeholder="Ingresa tu apellido materno">
            </div>
            <div class="col-md-3 form-group">
                <label for="diaNacimiento" class="form-label">Día de nacimiento</label>
                <input type="number" class="form-control" id="diaNacimiento" name="diaNacimiento" placeholder="Día" min="1" max="31" required>
            </div>
            <div class="col-md-3 form-group">
                <label for="mesNacimiento" class="form-label">Mes de nacimiento</label>
                <input type="number" class="form-control" id="mesNacimiento" name="mesNacimiento" placeholder="Mes" min="1" max="12" required>
            </div>
            <div class="col-md-3 form-group">
                <label for="anioNacimiento" class="form-label">Año de nacimiento</label>
                <input type="number" class="form-control" id="anioNacimiento" name="anioNacimiento" placeholder="Año" required>
            </div>
            <div class="col-md-3 form-group">
                <label for="genero" class="form-label">Género</label>
                <select class="form-select" id="genero" name="genero" required>
                    <option value="1">Masculino</option>
                    <option value="2">Femenino</option>
                    <option value="0">Otro</option>
                </select>
            </div>
        </div>
        <button type="button" class="btn btn-primary next-step">Siguiente</button>
    </div>

    <div class="step d-none" id="step-2">
        <h4>Paso 2: Dirección</h4>
        <div class="form-row">
            <div class="col-md-6 form-group">
                <label for="calle" class="form-label">Calle</label>
                <input type="text" class="form-control" id="calle" name="calle" placeholder="Ingresa tu calle" required>
            </div>
            <div class="col-md-3 form-group">
                <label for="numeroInterior" class="form-label">Número Interior</label>
                <input type="text" class="form-control" id="numeroInterior" name="numeroInterior" placeholder="Ingresa tu número interior" required>
            </div>
            <div class="col-md-3 form-group">
                <label for="numeroExterior" class="form-label">Número Exterior</label>
                <input type="text" class="form-control" id="numeroExterior" name="numeroExterior" placeholder="Ingresa tu número exterior">
            </div>
            <div class="col-md-6 form-group">
                <label for="colonia" class="form-label">Fraccionamiento/Colonia</label>
                <input type="text" class="form-control" id="colonia" name="colonia" placeholder="Ingresa tu colonia" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="codigoPostal" class="form-label">Código Postal</label>
                <input type="text" class="form-control" id="codigoPostal" name="codigoPostal" placeholder="Ingresa tu código postal" required>
            </div>
        </div>
        <button type="button" class="btn btn-secondary prev-step">Anterior</button>
        <button type="button" class="btn btn-primary next-step">Siguiente</button>
    </div>

    <div class="step d-none" id="step-3">
        <h4>Paso 3: Datos Académicos y Contacto</h4>
        <div class="form-row">
            <div class="col-md-6 form-group">
                <label for="licenciatura" class="form-label">Licenciatura</label>
                <select class="form-select" id="licenciatura" name="licenciatura" required>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label for="tipoLicenciatura" class="form-label">Tipo de Licenciatura</label>
                <select class="form-select" id="tipoLicenciatura" name="tipoLicenciatura" required>
                    <option value="semestral">Semestral</option>
                    <option value="cuatrimestral">Cuatrimestral</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label for="grado" class="form-label">Grado</label>
                <input type="number" class="form-control" id="grado" name="grado" placeholder="Ingresa tu grado" required>
            </div>
            <div class="col-md-6 form-group position-relative">
                <label for="correoInstitucional" class="form-label">Correo Institucional <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="Debe ser de la forma @unimontrer.edu.mx"></i></label>
                <input type="email" class="form-control" id="correoInstitucional" name="correoInstitucional" placeholder="correo@unimontrer.edu.mx" required>
                <div class="invalid-feedback">El correo debe ser de la forma @unimontrer.edu.mx.</div>
                <div class="valid-feedback">Correo válido.</div>
            </div>
            <div class="col-md-6 form-group position-relative">
                <label for="telefonoContacto" class="form-label">Celular del alumno <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="Debe contener 10 dígitos"></i></label>
                <input type="tel" class="form-control" id="telefonoContacto" name="telefonoContacto" placeholder="Ingresa tu teléfono de contacto" required>
                <div class="invalid-feedback">El teléfono de contacto debe contener 10 dígitos.</div>
                <div class="valid-feedback">Teléfono válido.</div>
            </div>
            <div class="col-md-6 form-group position-relative">
                <label for="telefonoEmergencia" class="form-label">Teléfono de Emergencia <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="Debe contener 10 dígitos"></i></label>
                <input type="tel" class="form-control" id="telefonoEmergencia" name="telefonoEmergencia" placeholder="Ingresa tu teléfono de emergencia" required>
                <div class="invalid-feedback">El teléfono de emergencia debe contener 10 dígitos.</div>
                <div class="valid-feedback">Teléfono válido.</div>
            </div>
            <div class="col-md-6 form-group">
                <label for="parentesco" class="form-label">Parentesco</label>
                <input type="text" class="form-control" id="parentesco" name="parentesco" placeholder="Ingresa tu parentesco" required>
            </div>
        </div>
        <button type="button" class="btn btn-secondary prev-step">Anterior</button>
        <button type="submit" class="btn btn-primary w-100" id="submitBtn">Registrar</button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let currentStep = 0;
        const steps = document.querySelectorAll('.step');
        const nextBtns = document.querySelectorAll('.next-step');
        const prevBtns = document.querySelectorAll('.prev-step');

        function showStep(stepIndex) {
            steps.forEach((step, index) => {
                step.classList.toggle('d-none', index !== stepIndex);
            });
        }

        nextBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                if (currentStep < steps.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                }
            });
        });

        prevBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            });
        });

        showStep(currentStep);
    });
</script>


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
            licenciatura();
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

                    var formData = $(this).serializeArray(); // Serializa el formulario a un array de objetos
                    formData.push({ name: 'search', value: 'student' });
                    formData.push({ name: 'action', value: 'addStudent' });

                    $.ajax({
                        url: 'controller/ajax/ajax.forms.php',
                        method: 'POST',
                        data: formData,
                        success: function (response) {
                            submitBtn.prop('disabled', false).removeClass('btn-loading').text('Registrar');
                            if (response === '"success"') {
                                showAlert('successMessage');
                            } else if (response === '"duplicate"') {
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
                    window.location.reload();
                }, 3000);
            }

            window.hideAlert = function(messageId) {
                $('#' + messageId).addClass('alert-hide').removeClass('alert-show');
            }
        });
        function licenciatura() {
            $.ajax({
                type: 'POST',
                url: "controller/ajax/ajax.forms.php",
                dataSrc: '',
                data: {
                    search: 'degrees'
                },
                dataType: 'json',
                success: function (response) {
                    let options = '<option value="">Seleccione licenciatura</option>';
                    $.each(response, function (index, item) {
                        options += '<option value="' + item.idDegree + '">' + item.nameDegree + '</option>';
                    });
                    $('#licenciatura').html(options);
                }
            });
        }
    </script>
</body>

</html>
