<?php
require_once "../../model/forms.models.php";
require_once "../forms.controller.php";

if (isset($_POST['search'])) {

    if ($_POST['search'] == 'users') {
        $user = (isset($_POST['user'])) ? $_POST['user'] : null;
        $searchUsers = new FormsController();
        if (isset($_POST['action'])) {
            if ($_POST['action'] == 'usersToAreas'){
                $users = $searchUsers->ctrUsersToAreas($_POST['idArea']);
            }
            if ($_POST['action'] == 'updateUsersToArea'){
                $users = $searchUsers->ctrUpdateUsersToAreas($_POST['idArea'], $_POST['idUser']);
            }
        } else {
            // $users = $searchUsers->ctrSearchUsers($user);
        }
        echo json_encode($users);
    }

    if ($_POST['search'] == 'areas') {
        $area = (isset($_POST['area'])) ? $_POST['area'] : null;

        $searchAreas = new FormsController();
        if (isset($_POST['editArea'])) {
            $areas = $searchAreas->ctrEditArea($_POST['editArea'], $_POST['nameArea']);
        } elseif (isset($_POST['deleteArea'])) {
            $areas = $searchAreas->ctrDeleteArea($_POST['deleteArea']);
        } elseif (isset($_POST['addArea'])) {
            $areas = $searchAreas->ctrAddArea($_POST['nameArea']);
        } else {
            $areas = $searchAreas->ctrSearchAreas($area);
        }

        echo json_encode($areas);
    }

    if ($_POST['search'] == 'event_types') {
        $eventType = (isset($_POST['eventType'])) ? $_POST['eventType'] : null;
        $searchEventTypes = new FormsController();
        if (isset($_POST['editEventType'])) {
            $eventTypes = $searchEventTypes->ctrEditEventType($_POST['editEventType'], $_POST['editEventTypeName'], $_POST['editAreaEncargada'], $_POST['editEventTypePoints'], $_POST['editEventTypeBenefits']);
        } elseif (isset($_POST['deleteEventType'])) {
            $eventTypes = $searchEventTypes->ctrDeleteEventType($_POST['deleteEventType']);
        } elseif (isset($_POST['eventTypePoints'])) {
            $eventTypes = $searchEventTypes->ctrAddEventType($_POST['eventTypeName'], $_POST['eventTypePoints'], $_POST['eventTypeBenefits'], $_POST['areaEncargada']);
        } else {
            $eventTypes = $searchEventTypes->ctrSearchEventTypes($eventType);
        }
        echo json_encode($eventTypes);
    }

    if ($_POST['search'] == 'courses') {
        $course = (isset($_POST['idCourse'])) ? $_POST['idCourse'] : null;
        $searchCourses = new FormsController();
        if (isset($_POST['editCourse'])) {
            $courses = $searchCourses->ctrEditCourse($_POST['idCourse'], $_POST['nameCourse'], $_POST['startCourse'], $_POST['endCourse']);
        } elseif (isset($_POST['deleteCourse'])) {
            $courses = $searchCourses->ctrDeleteCourse($_POST['deleteCourse']);
        } elseif (isset($_POST['addCourse'])) {
            $courses = $searchCourses->ctrAddCourse($_POST['nameCourse'], $_POST['startCourse'], $_POST['endCourse']);
        } else {
            $courses = $searchCourses->ctrGetCourses($course);
        }
        echo json_encode($courses);
    }

    if ($_POST['search'] == 'student') {
        $student = (isset($_POST['idStudent']))? $_POST['idStudent'] : null;
        $searchStudents = new FormsController();
        if (isset($_POST['action'])) {

            if ($_POST['action'] == 'acceptStudent') {

                $students = $searchStudents->ctrAcceptStudent($_POST['idStudent']);

            } elseif ($_POST['action'] == 'denegateStudent') {

                $students = $searchStudents->ctrDenegateStudent($_POST['idStudent']);

            } elseif ($_POST['action'] == 'dropStudent') {

                $students = $searchStudents->ctrDropStudent($_POST['idStudent'], $_POST['reason']);
                
            } elseif ($_POST['action'] == 'getStudent') {

                $students = $searchStudents->ctrSearchStudents($student);

            } elseif ($_POST['action'] == 'addStudent') {

                $matricula = $_POST['matricula'];
                $nombre = $_POST['nombre'];
                $apellidos = ($_POST['apellidoMaterno'] != '') ? $_POST['apellidoPaterno'] . ' ' . $_POST['apellidoMaterno'] : $_POST['apellidoPaterno'];
                $licenciatura = $_POST['licenciatura'];
                $tipoLicenciatura = $_POST['tipoLicenciatura'];
                $grado = $_POST['grado'];
                $correoInstitucional = $_POST['correoInstitucional'];
                $telefonoContacto = $_POST['telefonoContacto'];
                $telefonoEmergencia = $_POST['telefonoEmergencia'];
                $parentesco = $_POST['parentesco'];

                // Aquí puedes agregar el resto de los campos
                $calle = $_POST['calle'];
                $numeroInterior = $_POST['numeroInterior'];
                $numeroExterior = $_POST['numeroExterior'];
                $colonia = $_POST['colonia'];
                $codigoPostal = $_POST['codigoPostal'];
                $diaNacimiento = $_POST['diaNacimiento'];
                $mesNacimiento = $_POST['mesNacimiento'];
                $anioNacimiento = $_POST['anioNacimiento'];
                $genero = $_POST['genero'];

                $data = array(
                    'matricula' => $matricula,
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'licenciatura' => $licenciatura,
                    'tipoLicenciatura' => $tipoLicenciatura,
                    'grado' => $grado,
                    'correoInstitucional' => $correoInstitucional,
                    'telefonoContacto' => $telefonoContacto,
                    'telefonoEmergencia' => $telefonoEmergencia,
                    'parentesco' => $parentesco,
                    'calle' => $calle,
                    'numeroInterior' => $numeroInterior,
                    'numeroExterior' => $numeroExterior,
                    'colonia' => $colonia,
                    'codigoPostal' => $codigoPostal,
                    'diaNacimiento' => $diaNacimiento,
                    'mesNacimiento' => $mesNacimiento,
                    'anioNacimiento' => $anioNacimiento,
                    'genero' => $genero
                );

                $students = $searchStudents->ctrRegisterStudent($data);
            } elseif ($_POST['action'] == 'editStudent') {

                $matricula = $_POST['matricula'];
                $nombre = $_POST['firstname'];
                $apellidos = $_POST['lastname'];
                $licenciatura = $_POST['licenciatura'];
                $tipoLicenciatura = $_POST['tipoLicenciatura'];
                $grado = $_POST['grado'];
                $correoInstitucional = $_POST['correoInstitucional'];
                $telefonoContacto = $_POST['telefonoContacto'];
                $telefonoEmergencia = $_POST['telefonoEmergencia'];
                $parentesco = $_POST['parentesco'];

                // Aquí puedes agregar el resto de los campos
                $calle = $_POST['calle'];
                $numeroInterior = $_POST['numeroInterior'];
                $numeroExterior = $_POST['numeroExterior'];
                $colonia = $_POST['colonia'];
                $codigoPostal = $_POST['codigoPostal'];
                $diaNacimiento = $_POST['diaNacimiento'];
                $mesNacimiento = $_POST['mesNacimiento'];
                $anioNacimiento = $_POST['anioNacimiento'];
                $genero = $_POST['genero'];
                $idStudent = $_POST['idStudent'];

                $data = array(
                    'matricula' => $matricula,
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'licenciatura' => $licenciatura,
                    'tipoLicenciatura' => $tipoLicenciatura,
                    'grado' => $grado,
                    'correoInstitucional' => $correoInstitucional,
                    'telefonoContacto' => $telefonoContacto,
                    'telefonoEmergencia' => $telefonoEmergencia,
                    'parentesco' => $parentesco,
                    'calle' => $calle,
                    'numeroInterior' => $numeroInterior,
                    'numeroExterior' => $numeroExterior,
                    'colonia' => $colonia,
                    'codigoPostal' => $codigoPostal,
                    'diaNacimiento' => $diaNacimiento,
                    'mesNacimiento' => $mesNacimiento,
                    'anioNacimiento' => $anioNacimiento,
                    'genero' => $genero,
                    'idStudent' => $idStudent,
                );

                $students = $searchStudents->ctrEditStudent($data);

            } else {
                $students = 'none';
            }

        } else {
            $students = $searchStudents->ctrSearchStudents($student);
        }
        echo json_encode($students);
    }

    if ($_POST['search'] == 'degrees') {
        $degree = (isset($_POST['idDegree']))? $_POST['idDegree'] : null;
        $searchDegrees = new FormsController();
        $degrees = $searchDegrees->ctrSearchDegrees($degree);
        echo json_encode($degrees);
    }

    if ($_POST['search'] == 'event') {
        $event = (isset($_POST['idEvent']))? $_POST['idEvent'] : null;
        $searchEvents = new FormsController();
        if (isset($_POST['action'])) {
            if ($_POST['action'] == 'applyEvent') {
                $events = $searchEvents->ctrApplyEvent($_POST['idEvent'], $_POST['idStudent']);
            } elseif ($_POST['action'] == 'checkApplication') {
                $events = $searchEvents->ctrCheckApplicationEvent($_POST['idEvent'], $_POST['idStudent']);
            } elseif ($_POST['action'] == 'studentEvents'){
                $events = $searchEvents->ctrStudentEvents($event);
            } elseif ($_POST['action'] == 'lookCandidates'){
                $events = $searchEvents->ctrEventsCandidates($event);
            }
        } else {
            $events = $searchEvents->ctrSearchEvents($event);
        }
        echo json_encode($events);
    }
}

if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['role'])) {
    $registerUser = new FormsController();
    $registerUser->ctrRegisterUser();
}

if (isset($_POST['nombreLicenciatura']) && isset($_POST['puntajeMinimo'])) {

    $data = array(
        "nameDegree" => $_POST['nombreLicenciatura'],
        "minPoints" => $_POST['puntajeMinimo']
    );
    $registerDegree = new FormsController();
    $response = $registerDegree->ctrAddDegree($data);

    echo $response;
}
