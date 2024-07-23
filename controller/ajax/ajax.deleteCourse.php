<?php
require_once "../../model/forms.models.php";

    $idCourse = $_POST['idCourse'];

    $response = FormsModel::mdlDeleteCourse($idCourse);
    echo $response;
