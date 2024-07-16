<?php
require_once "../../model/forms.models.php";

$users = FormsModel::mdlGetUsers();
echo json_encode($users);