<?php
require_once "../../model/forms.models.php";

    $events = FormsModel::mdlGetCourses();
    echo json_encode($events);
