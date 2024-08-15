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

            // If the update is successful, send the password to the student by email
            if ($response == 'success') {
                $searchStudent = FormsModel::mdlSearchStudents($student);
                if ($searchStudent) {
                    $this->sendPasswordToStudent($searchStudent["email"], $password);
                }
            }
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
        $subject = 'Servicio social UNIMO - Nueva contraseña';
    
        $message = '
        <html>
        <head>
            <title>Servicio social UNIMO - Nueva contraseña</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
                .email-container {
                    width: 100%;
                    background-color: #ffffff;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    max-width: 600px;
                    margin: 20px auto;
                    overflow: hidden;
                }
                .header {
                    background-color: #01643D;
                    padding: 20px;
                    border-radius: 10px 10px 0 0;
                    color: white;
                    text-align: center;
                }
                .header img {
                    max-width: 200px;
                    margin-bottom: 10px;
                }
                .header h1 {
                    margin: 0;
                    font-size: 22px;
                    line-height: 1.4;
                }
                .content {
                    padding: 20px;
                    text-align: left;
                }
                .content p {
                    font-size: 16px;
                    color: #333333;
                    line-height: 1.5;
                    margin-bottom: 20px;
                }
                .content .info-box {
                    background-color: #e7f5ec;
                    color: #01643D;
                    padding: 10px;
                    border-radius: 5px;
                    font-weight: bold;
                    text-align: center;
                    margin-bottom: 20px;
                    text-decoration: none;
                }
                .content a.button {
                    display: inline-block;
                    background-color: #01643D;
                    color: #ffffff;
                    padding: 12px 20px;
                    text-decoration: none;
                    border-radius: 5px;
                    font-size: 16px;
                    font-weight: bold;
                    text-align: center;
                    margin-top: 20px;
                }
                .footer {
                    text-align: center;
                    padding: 20px;
                    font-size: 12px;
                    color: #999999;
                    background-color: #f4f4f4;
                    border-radius: 0 0 10px 10px;
                }
                .footer a {
                    color: #01643D;
                    text-decoration: none;
                }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="header">
                    <img src="https://campuscare.devosco.io/view/assets/images/logo.png" alt="UNIMO Logo">
                    <h1>Bienvenido al servicio social de UNIMO</h1>
                </div>
                <div class="content">
                    <p>Hola,</p>
                    <p>¡Bienvenido al servicio social de UNIMO! Estamos emocionados de que formes parte de nuestro programa.</p>
                    <p>Tu email registrado es:</p>
                    <p class="info-box">' . $email . '</p>
                    <p>Tu contraseña es:</p>
                    <p class="info-box">' . $password . '</p>
                    <p>Para iniciar sesión en nuestra plataforma, haz clic en el botón de abajo o visita nuestro sitio web.</p>
                    <p style="text-align: center;"><a href="https://campuscare.devosco.io/login?mail='.$email.'&password='.$password.'" target="_blank" class="button">Iniciar sesión</a></p>
                </div>
                <div class="footer">
                    <p>Si tienes alguna pregunta, no dudes en <a href="mailto:olopez@unimontrer.edu.mx">contactarnos</a>.</p>
                    <p>&copy; ' . date("Y") . ' CampusCare. Todos los derechos reservados.</p>
                </div>
            </div>
        </body>
        </html>';
    
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $headers .= 'From: Servicio social UNIMO <olopez@unimontrer.edu.mx>' . "\r\n" .
                    'Reply-To: Servicio social UNIMO <olopez@unimontrer.edu.mx>' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
    
        return mail($email, $subject, $message, $headers);
    }    

    public function ctrGetEvents() {
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

    static public function ctrSearchEvents($idEvent) {
        return FormsModel::mdlSearchEvents($idEvent);
    }

    static public function ctrStudentEvents($idEvent) {
        return FormsModel::mdlStudentEvents($idEvent);
    }

    static public function ctrEventsCandidates($idEvent) {
        return FormsModel::mdlEventsCandidates($idEvent);
    }

    static public function ctrUsersToAreas($idArea) {
        return FormsModel::mdlUsersToAreas($idArea);
    }

    static public function ctrUpdateUsersToAreas($idArea, $idUser) {
        return FormsModel::mdlUpdateUsersToAreas($idArea, $idUser);
    }

    static public function ctrSearchUsers($idUser) {
        return FormsModel::mdlSearchUsers($idUser);
    }

    static public function ctrAcceptCandidate($idStudent, $idEvent, $idUser, $status) {
        if ($status == 1) {
            return FormsModel::mdlAcceptCandidate($idStudent, $idEvent, $idUser);
        } else {
            return FormsModel::mdlDeclineCandidate($idStudent, $idEvent, $idUser);
        }
    }

    static public function ctrApproveEvent($idStudent, $idEvent, $idUser, $status) {
        if ($status == 1) {
            $points = FormsModel::mdlGetPointsEvent($idEvent);
            return FormsModel::mdlApproveEvent($idStudent, $idEvent, $idUser, $points['points']);
        } else {
            return FormsModel::mdlDeclineEvent($idStudent, $idEvent, $idUser);
        }
    }
}
