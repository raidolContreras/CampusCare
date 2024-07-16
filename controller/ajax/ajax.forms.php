<?php
require_once "../../model/forms.models.php";
require_once "../forms.controller.php";

if (isset($_POST['name'])) {
    $registerUser = new FormsController();
    $registerUser->ctrRegisterUser();
}
