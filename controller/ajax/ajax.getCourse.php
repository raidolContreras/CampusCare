<?php
require_once "../../model/forms.models.php";

    $idCourse = $_POST['idCourse'];

    $response = FormsModel::mdlGetCourseById($idCourse);
    echo $response;