<?php
require_once "../../model/forms.models.php";

    $nameCourse = $_POST['nameCourse'];
    $startCourse = $_POST['startCourse'];
    $endCourse = $_POST['endCourse'];

    $response = FormsModel::mdlAddCourse($nameCourse, $startCourse, $endCourse);
    echo $response;
