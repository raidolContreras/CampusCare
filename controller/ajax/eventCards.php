<?php
require_once "../../model/forms.models.php";
require_once "../forms.controller.php";
$idStudent = (isset($_POST['idStudent'])) ? $_POST['idStudent'] : null;
$controller = new FormsController();
$response = $controller->ctrGetEvents($idStudent);

echo json_encode($response);