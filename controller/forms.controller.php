<?php
class FormsController {
    public function ctrRegisterEvent() {
        // Código para registrar eventos
    }

    public function ctrRegisterUser() {
        if (isset($_POST["name"])) {
            $table = "users";
            $data = array(
                "name" => $_POST["name"],
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
