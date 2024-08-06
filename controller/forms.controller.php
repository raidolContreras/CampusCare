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
                $student = FormsModel::mdlGetStudent($_POST['email']);
                if ($student && password_verify($_POST["password"], $student["password"])) {
                    session_start();
                    $student['role'] = 'student'; 
                    $_SESSION["logged"] = true;
                    $_SESSION["user"] = $student;
                    echo 'success';
                } else {
                    echo 'error';
                }
            }
        }
    }

    public function ctrGradeStudent($data) {
        return FormsModel::mdlGradeStudent($data);
    }

    public function ctrSearchAreas($idArea) {
        return FormsModel::mdlSearchAreas($idArea);
    }

    public function ctrEditArea($editArea, $nameArea) {
        return FormsModel::mdlEditArea($editArea, $nameArea);
    }

    public function ctrDeleteArea($deleteArea) {
        return FormsModel::mdlDeleteArea($deleteArea);
    }
    
    public function ctrAddArea($nameArea) {
        return FormsModel::mdlAddArea($nameArea);
    }

    public function ctrSearchEventTypes($idEventType) {
        return FormsModel::mdlSearchEventTypes($idEventType);
    }

    public function ctrEditEventType($editEventType, $name, $idArea, $pointsPerEvent, $benefitsPerYear) {
        return FormsModel::mdlEditEventTypes($editEventType, $name, $idArea, $pointsPerEvent, $benefitsPerYear);
    }

    public function ctrDeleteEventType($deleteEventType) {
        return FormsModel::mdlDeleteEventTypes($deleteEventType);
    }
    
    public function ctrAddEventType($name, $pointsPerEvent, $benefitsPerYear, $idArea) {
        return FormsModel::mdlAddEventTypes($name, $pointsPerEvent, $benefitsPerYear, $idArea);
    }
    
    public function ctrGetCourses($idCourse) {
        return FormsModel::mdlGetCourses($idCourse);
    }

    public function ctrAddCourse($nameCourse, $startCourse, $endCourse) {
        return FormsModel::mdlAddCourse($nameCourse, $startCourse, $endCourse);
    }

    public function ctrEditCourse($idCourse, $nameCourse, $startCourse, $endCourse) {
        return FormsModel::mdlUpdateCourse($idCourse, $nameCourse, $startCourse, $endCourse);
    }

    public function ctrDeleteCourse($deleteCourse) {
        return FormsModel::mdlDeleteCourse($deleteCourse);
    }
    
    public function ctrSearchStudents($student) {
        return FormsModel::mdlSearchStudents($student);
    }

    public function ctrAcceptStudent($student) {
        $response = FormsModel::mdlAcceptStudent($student);
        if ($response == 'success') {
            // Generate a random password
            $password = $this->generateRandomPassword();

            $cryptPass = password_hash($password, PASSWORD_DEFAULT);

            $response = FormsModel::mdlAddPasswordStudent($cryptPass, $student);

            // // If the update is successful, send the password to the student by email
            // if ($updateResponse == 'success') {
            // }
        }
        return $password;
    }
    
    public function ctrDenegateStudent($idStudent) {
        return FormsModel::mdlDenegateStudent($idStudent);
    }
    
    public function ctrDropStudent($idStudent, $reason) {
        return FormsModel::mdlDropStudent($idStudent, $reason);
    }

    private function generateRandomPassword($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function sendPasswordToStudent($email, $password) {
        // Send the password to the student by email
        // Example:
        // $to = $email;
        // $subject = 'Your Campus Care Password';
        // $message = 'Your password is: '. $password;
        // $headers = 'From: Campus Care <noreply@campuscare.com>';
        // mail($to, $subject, $message, $headers);
        // return true;
        return false; // Placeholder for actual sending function
    }

    public function ctrGetEvents($idStudent) {
        return FormsModel::mdlGetEvents();
    }

    static public function ctrAddDegree($data) {
        return FormsModel::mdlAddDegree($data);
    }

    static public function ctrSearchDegrees($idDegree) {
        return FormsModel::mdlSearchDegrees($idDegree);
    }

    static public function ctrRegisterStudent($data) {
        return FormsModel::mdlRegisterStudent($data);
    }

    static public function ctrEditStudent($data) {
        return FormsModel::mdlEditStudent($data);
    }

    static public function ctrApplyEvent($idEvent, $idStudent) {
        return FormsModel::mdlApplyEvent($idEvent, $idStudent);
    }

    static public function ctrCheckApplicationEvent($idEvent, $idStudent) {
        return FormsModel::mdlCheckApplicationEvent($idEvent, $idStudent);
    }
}
