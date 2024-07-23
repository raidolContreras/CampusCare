<?php
require_once "../../model/forms.models.php";

$id = $_POST['id'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$role = $_POST['role'];

$response = FormsModel::mdlUpdateUser($id, $firstname, $lastname, $email, $role);
echo $response;
