<?php
require_once "../../model/forms.models.php";
require_once "../forms.controller.php";

if (isset($_POST['search'])) {
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
            }
        } else {
            $students = $searchStudents->ctrSearchStudents($student);
        }
        echo json_encode($students);
    }
}

// Añadir funcionalidad de registro de estudiantes
if (isset($_POST['matricula']) && isset($_POST['nombre']) && isset($_POST['apellidos']) && isset($_POST['licenciatura']) && isset($_POST['tipoLicenciatura']) && isset($_POST['grado']) && isset($_POST['correoInstitucional']) && isset($_POST['telefonoContacto']) && isset($_POST['telefonoEmergencia']) && isset($_POST['parentesco'])) {
    $matricula = $_POST['matricula'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $licenciatura = $_POST['licenciatura'];
    $tipoLicenciatura = $_POST['tipoLicenciatura'];
    $grado = $_POST['grado'];
    $correoInstitucional = $_POST['correoInstitucional'];
    $telefonoContacto = $_POST['telefonoContacto'];
    $telefonoEmergencia = $_POST['telefonoEmergencia'];
    $parentesco = $_POST['parentesco'];

    $registerStudent = new FormsController();
    $response = $registerStudent->ctrRegisterStudent($matricula, $nombre, $apellidos, $licenciatura, $tipoLicenciatura, $grado, $correoInstitucional, $telefonoContacto, $telefonoEmergencia, $parentesco);

    echo $response;
}

if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['role'])) {
    $registerUser = new FormsController();
    $registerUser->ctrRegisterUser();
}