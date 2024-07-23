<?php
require_once "../../model/forms.models.php";

$id = $_POST['id'];

$response = FormsModel::mdlDeleteUser($id);
echo $response;
