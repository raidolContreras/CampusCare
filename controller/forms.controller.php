<?php
class FormsController {

    public function ctrRegisterUser() {
        if (isset($_POST["firstname"])) {
            $table = "users";
            $data = array(
                "firstname" => $_POST["firstname"],
                "lastname" => $_POST["lastname"],
                "email" => $_POST["email"],
                "password" => password_hash($_POST["password"], PASSWORD_DEFAULT),
                "role" => $_POST["role"]
            );
            $response = FormsModel::mdlRegisterUser($table, $data);
            echo $response ? 'success' : 'error';
        }
    }

    public function ctrLogin() {
        if (isset($_POST["email"]) && isset($_POST["password"])) {
            $table = "users";
            $item = "email";
            $value = $_POST["email"];
            $response = FormsModel::mdlShowUser($table, $item, $value);
            if ($response && password_verify($_POST["password"], $response["password"])) {
                session_start();
                $_SESSION["logged"] = true;
                $_SESSION["user"] = $response;
                echo 'success';
            } else {
                echo 'error';
            }
        }
    }

    public function ctrGradeStudent($data) {
        return FormsModel::mdlGradeStudent($data);
    }
    

}
