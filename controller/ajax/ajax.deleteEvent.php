<?php
require_once "../../model/forms.models.php";

    $idEvent = $_POST['idEvent'];

    $response = FormsModel::mdlDeleteEvent($idEvent);
    echo $response;
