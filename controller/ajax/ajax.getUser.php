<?php
require_once "../../model/forms.models.php";

$id = $_GET['id'];
$user = FormsModel::mdlGetUserById($id);
echo json_encode($user);
