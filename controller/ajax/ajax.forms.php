<?php
require_once "../../model/forms.models.php";
require_once "../forms.controller.php";

if (isset($_POST['name'])) {
    $registerUser = new FormsController();
    $registerUser->ctrRegisterUser();
}

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
        $eventType = (isset($_POST['eventType']))? $_POST['eventType'] : null;
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
}