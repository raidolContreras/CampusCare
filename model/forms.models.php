<?php
include "conection.php";
require_once __DIR__ . '/../vendor/autoload.php';

use setasign\Fpdi\Fpdi;

class FormsModel {
    
// Users
    
    static public function mdlRegisterUser($table, $data) {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $table (firstname, lastname, email, password, role) VALUES (:firstname, :lastname, :email, :password, :role)");
        $stmt->bindParam(":firstname", $data["firstname"], PDO::PARAM_STR);
        $stmt->bindParam(":lastname", $data["lastname"], PDO::PARAM_STR);
        $stmt->bindParam(":email", $data["email"], PDO::PARAM_STR);
        $stmt->bindParam(":password", $data["password"], PDO::PARAM_STR);
        $stmt->bindParam(":role", $data["role"], PDO::PARAM_STR);
        $response = $stmt->execute();
        $stmt -> closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlGetUsers() {
        $stmt = Conexion::conectar()->prepare("SELECT id, firstname, lastname, email, role, created_at FROM users");
        $stmt->execute();
        $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt -> closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlGetUserById($id) {
        $stmt = Conexion::conectar()->prepare("SELECT id, firstname, lastname, email, role FROM users WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $response = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt -> closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlUpdateUser($id, $firstname, $lastname, $email, $role) {
        $stmt = Conexion::conectar()->prepare("UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email, role = :role WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":firstname", $firstname, PDO::PARAM_STR);
        $stmt->bindParam(":lastname", $lastname, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":role", $role, PDO::PARAM_STR);

        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }

        $stmt -> closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlDeleteUser($id) {
        $stmt = Conexion::conectar()->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }

        $stmt -> closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlShowUser($table, $item, $value) {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $table u LEFT JOIN areas_users au ON au.idUser = u.id WHERE $item = :$item");
        $stmt->bindParam(":" . $item, $value, PDO::PARAM_STR);
        $stmt->execute();
        $response = $stmt->fetch();
        $stmt -> closeCursor();
        $stmt = null;
        return $response;
    }
    
    static public function mdlGradeStudent($data) {
        $stmt = Conexion::conectar()->prepare("UPDATE students SET points = points + :points WHERE id = :id");
        $stmt->bindParam(":points", $data["points"], PDO::PARAM_INT);
        $stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
        $response = $stmt->execute();
        $stmt -> closeCursor();
        $stmt = null;
        return $response;
    }
    
// Events

    static public function mdlRegisterEvent($data) {
        $stmt = Conexion::conectar()->prepare("INSERT INTO events (eventName, lastname, type, points) VALUES (:eventName, :lastname, :type, :points)");
        $stmt->bindParam(":eventName", $data["eventName"], PDO::PARAM_STR);
        $stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
        $stmt->bindParam(":points", $data["points"], PDO::PARAM_INT);
        $response = $stmt->execute();
        $stmt -> closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlGetEvents() {
        $stmt = Conexion::conectar()->prepare("SELECT e.*, et.* FROM events e LEFT JOIN event_types et ON et.idEventType = e.eventTypeId LEFT JOIN courses c ON c.idCourse = e.idCourse");
        $stmt->execute();
        $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlApplyEvent($idEvent, $idStudent) {
        $stmt = Conexion::conectar()->prepare("INSERT INTO students_events (idEvent, idStudent) VALUES (:idEvent, :idStudent)");
        $stmt->bindParam(":idEvent", $idEvent, PDO::PARAM_INT);
        $stmt->bindParam(":idStudent", $idStudent, PDO::PARAM_INT);
        $response = $stmt->execute();
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlCheckApplicationEvent($idEvent, $idStudent) {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM students_events WHERE idEvent = :idEvent AND idStudent = :idStudent");
        $stmt->bindParam(":idEvent", $idEvent, PDO::PARAM_INT);
        $stmt->bindParam(":idStudent", $idStudent, PDO::PARAM_INT);
        $stmt->execute();
        $response = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlAddEvent($eventTypeId, $eventName, $idUser, $date, $location, $start_time, $end_time, $points, $vacancies_available, $description) {
        $stmt = Conexion::conectar()->prepare("
            INSERT INTO events 
            (eventTypeId, eventName, idUser, date, location, start_time, end_time, points, vacancies_available, description, createdAt, idCourse) 
            VALUES 
            (:eventTypeId, :eventName, :idUser, :date, :location, :start_time, :end_time, :points, :vacancies_available, :description, NOW(), (SELECT idCourse FROM courses WHERE active = 1))
        ");
    
        $stmt->bindParam(":eventTypeId", $eventTypeId, PDO::PARAM_INT);
        $stmt->bindParam(":eventName", $eventName, PDO::PARAM_STR);
        $stmt->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $stmt->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt->bindParam(":location", $location, PDO::PARAM_STR);
        $stmt->bindParam(":start_time", $start_time, PDO::PARAM_STR);
        $stmt->bindParam(":end_time", $end_time, PDO::PARAM_STR);
        $stmt->bindParam(":points", $points, PDO::PARAM_INT);
        $stmt->bindParam(":vacancies_available", $vacancies_available, PDO::PARAM_INT);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
    
        if($stmt->execute()) {
            $response = "success";
            $students = self::mdlSearchStudents(null);
            foreach($students as $student) {
                $points = self::mdlStudentPoints($student['idStudent']);
                if($points['totalPoints'] < $points['degreeMinPoints']) {
                    // Mensaje personalizado
                    $message = "
                        <div style='font-family: Arial, sans-serif; line-height: 1.6; background-color: #f4f4f4; padding: 20px;'>
                            <div style='max-width: 600px; margin: auto; background-color: #ffffff; border: 1px solid #dddddd; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;'>
                                
                                <!-- Barra superior con logo -->
                                <div style='background-color: #01643d; padding: 10px; text-align: center;'>
                                    <img src='https://campuscare.devosco.io/view/assets/images/logo.png' alt='UNIMO Logo' style='max-width: 150px;'>
                                </div>
                            
                                <!-- Contenido del correo -->
                                <div style='padding: 20px;'>
                                    <p style='color: #01643d; font-size: 1.2em; font-weight: bold;'>Estimado/a Estudiante,</p>
                                    
                                    <p>Estimado estudiante, se ha creado un nuevo evento en el que puede participar. Este evento es: " . $eventName . ". Te recomendamos que te inscribas en él para continuar con tu servicio social.</p>
                                    
                                    <p>Te recomendamos que te inscribas en él para continuar con tu servicio social.</p>
                                    
                                    <p>Si tienes alguna pregunta adicional o necesitas más asistencia, no dudes en contactarnos.</p>
                                    
                                    <p>¡Que tengas un excelente día!</p>
                                </div>
                            
                                <!-- Pie de página -->
                                <div style='background-color: #f4f4f4; padding: 10px; text-align: center; color: #777777; font-size: 0.9em;'>
                                    Atentamente,<br>
                                    Universidad Montrer (UNIMO)
                                </div>
                            </div>
                        </div>";

                    // Enviar correo
                    mdlSendEmail($student['email'], $message);
                }
            }       
        } else {
            $response = "error";
        }
    
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }
    

    static public function mdlGetEventById($idEvent) {
        $stmt = Conexion::conectar()->prepare("SELECT idEvent, eventTypeId, eventName, date, location, start_time, end_time, points, vacancies_available, description FROM events WHERE idEvent = :idEvent");
        $stmt->bindParam(":idEvent", $idEvent, PDO::PARAM_INT);
        $stmt->execute();
        $response = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlUpdateEvent($idEvent, $eventTypeId, $eventName, $date, $location, $start_time, $end_time, $points, $vacancies_available, $description) {
        $stmt = Conexion::conectar()->prepare("UPDATE events SET eventTypeId = :eventTypeId, eventName = :eventName, date = :date, location = :location, start_time = :start_time, end_time = :end_time, points = :points, vacancies_available = :vacancies_available, description = :description WHERE idEvent = :idEvent");
        $stmt->bindParam(":idEvent", $idEvent, PDO::PARAM_INT);
        $stmt->bindParam(":eventTypeId", $eventTypeId, PDO::PARAM_INT);
        $stmt->bindParam(":eventName", $eventName, PDO::PARAM_STR);
        $stmt->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt->bindParam(":location", $location, PDO::PARAM_STR);
        $stmt->bindParam(":start_time", $start_time, PDO::PARAM_STR);
        $stmt->bindParam(":end_time", $end_time, PDO::PARAM_STR);
        $stmt->bindParam(":points", $points, PDO::PARAM_INT);
        $stmt->bindParam(":vacancies_available", $vacancies_available, PDO::PARAM_INT);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);

        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }

        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlDeleteEvent($idEvent) {
        $stmt = Conexion::conectar()->prepare("DELETE FROM events WHERE idEvent = :idEvent");
        $stmt->bindParam(":idEvent", $idEvent, PDO::PARAM_INT);

        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }

        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

// Courses
    static public function mdlGetCourses($idCourse) {
        
        if ($idCourse == null) {
            $sql = "SELECT * FROM courses";
            $stmt = Conexion::conectar()->prepare($sql);
            $stmt->execute();
            $response = $stmt->fetchAll();
        } else {
            $sql = "SELECT * FROM courses WHERE idCourse = :idCourse";
            $stmt = Conexion::conectar()->prepare($sql);
            $stmt->bindParam(":idCourse", $idCourse, PDO::PARAM_INT);
            $stmt->execute();
            $response = $stmt->fetch();
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlAddCourse($nameCourse, $startCourse, $endCourse) {
        $stmt = Conexion::conectar()->prepare("INSERT INTO courses (nameCourse, startCourse, endCourse) VALUES (:nameCourse, :startCourse, :endCourse)");

        $stmt->bindParam(":nameCourse", $nameCourse, PDO::PARAM_STR);
        $stmt->bindParam(":startCourse", $startCourse, PDO::PARAM_STR);
        $stmt->bindParam(":endCourse", $endCourse, PDO::PARAM_STR);

        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlGetCourseById($idCourse) {
        $stmt = Conexion::conectar()->prepare("SELECT idCourse, nameCourse, startCourse, endCourse FROM courses WHERE idCourse = :idCourse");
        $stmt->bindParam(":idCourse", $idCourse, PDO::PARAM_INT);
        $stmt->execute();
        $response = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlUpdateCourse($idCourse, $nameCourse, $startCourse, $endCourse) {
        $stmt = Conexion::conectar()->prepare("UPDATE courses SET nameCourse = :nameCourse, startCourse = :startCourse, endCourse = :endCourse WHERE idCourse = :idCourse");
        $stmt->bindParam(":idCourse", $idCourse, PDO::PARAM_INT);
        $stmt->bindParam(":nameCourse", $nameCourse, PDO::PARAM_STR);
        $stmt->bindParam(":startCourse", $startCourse, PDO::PARAM_STR);
        $stmt->bindParam(":endCourse", $endCourse, PDO::PARAM_STR);
        
        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlDeleteCourse($idCourse) {
        $stmt = Conexion::conectar()->prepare("DELETE FROM courses WHERE idCourse = :idCourse");
        $stmt->bindParam(":idCourse", $idCourse, PDO::PARAM_INT);
        
        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlActivateCourse($idCourse) {
        $sql = "UPDATE courses SET active = 0;";
        $sql .= "UPDATE courses SET active = 1 WHERE idCourse = :idCourse;";

        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":idCourse", $idCourse, PDO::PARAM_INT);
        
        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlSearchAreas($idArea) {
        if ($idArea == null) {
            $sql = "SELECT * FROM areas";
            $stmt = Conexion::conectar()->prepare($sql);
            $stmt->execute();
            $response = $stmt->fetchAll();
        } else {
            $sql = "SELECT * FROM areas WHERE idArea = :idArea";
            $stmt = Conexion::conectar()->prepare($sql);
            $stmt->bindParam(":idArea", $idArea, PDO::PARAM_INT);
            $stmt->execute();
            $response = $stmt->fetch();
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlEditArea($editArea, $nameArea) {
        $sql = "UPDATE areas SET nameArea = :nameArea WHERE idArea = :editArea";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":editArea", $editArea, PDO::PARAM_INT);
        $stmt->bindParam(":nameArea", $nameArea, PDO::PARAM_STR);
        
        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlDeleteArea($idArea) {
        $sql = "DELETE FROM areas WHERE idArea = :idArea";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":idArea", $idArea, PDO::PARAM_INT);
        
        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlAddArea($nameArea) {
        $sql = "INSERT INTO areas (nameArea) VALUES (:nameArea)";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":nameArea", $nameArea, PDO::PARAM_STR);
        
        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlSearchEventTypes($idEventType) {
        if ($idEventType == null) {
            $sql = "SELECT * FROM event_types et LEFT JOIN areas a on a.idArea = et.idArea";
            $stmt = Conexion::conectar()->prepare($sql);
            $stmt->execute();
            $response = $stmt->fetchAll();
        } else {
            $sql = "SELECT * FROM event_types WHERE idEventType = :idEventType";
            $stmt = Conexion::conectar()->prepare($sql);
            $stmt->bindParam(":idEventType", $idEventType, PDO::PARAM_INT);
            $stmt->execute();
            $response = $stmt->fetch();
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlEditEventTypes($editEventType, $name, $idArea, $pointsPerEvent, $benefitsPerYear) {
        $sql = "UPDATE event_types SET name = :name, idArea = :idArea, pointsPerEvent = :pointsPerEvent, benefitsPerYear = :benefitsPerYear WHERE idEventType = :editEventType";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":editEventType", $editEventType, PDO::PARAM_INT);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":idArea", $idArea, PDO::PARAM_INT);
        $stmt->bindParam(":pointsPerEvent", $pointsPerEvent, PDO::PARAM_INT);
        $stmt->bindParam(":benefitsPerYear", $benefitsPerYear, PDO::PARAM_INT);
        
        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }
    
    static public function mdlDeleteEventTypes($idEventType) {
        $sql = "DELETE FROM event_types WHERE idEventType = :idEventType";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":idEventType", $idEventType, PDO::PARAM_INT);
        
        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlAddEventTypes($name, $pointsPerEvent, $benefitsPerYear, $idArea) {
        $sql = "INSERT INTO event_types (name, pointsPerEvent, benefitsPerYear, idArea) VALUES (:name, :pointsPerEvent, :benefitsPerYear, :idArea)";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":pointsPerEvent", $pointsPerEvent, PDO::PARAM_INT);
        $stmt->bindParam(":benefitsPerYear", $benefitsPerYear, PDO::PARAM_INT);
        $stmt->bindParam(":idArea", $idArea, PDO::PARAM_INT);
        
        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    public static function mdlRegisterStudent($data) {
        try {
            $stmt = Conexion::conectar()->prepare("INSERT INTO student(matricula, firstname, lastname, lastnameMom, idDegree, grado, email, phone, emergenci_phone, parent, type_lic, street, nInt, nExt, colony, cp, dayBirthday, monthBirthday, yearBirthday, gender, idCourse) VALUES (:matricula, :firstname, :lastname, :lastnameMom, :idDegree, :grado, :email, :phone, :emergenci_phone, :parent, :type_lic, :street, :nInt, :nExt, :colony, :cp, :dayBirthday, :monthBirthday, :yearBirthday, :gender, (SELECT idCourse FROM courses WHERE active = 1))");
            
            $stmt->bindParam(':matricula', $data['matricula'], PDO::PARAM_STR);
            $stmt->bindParam(':firstname', $data['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $data['apellidoP'], PDO::PARAM_STR);
            $stmt->bindParam(':lastnameMom', $data['apellidoM'], PDO::PARAM_STR);
            $stmt->bindParam(':idDegree', $data['licenciatura'], PDO::PARAM_INT);
            $stmt->bindParam(':grado', $data['grado'], PDO::PARAM_INT);
            $stmt->bindParam(':email', $data['correoInstitucional'], PDO::PARAM_STR);
            $stmt->bindParam(':phone', $data['telefonoContacto'], PDO::PARAM_STR);
            $stmt->bindParam(':emergenci_phone', $data['telefonoEmergencia'], PDO::PARAM_STR);
            $stmt->bindParam(':parent', $data['parentesco'], PDO::PARAM_STR);
            $stmt->bindParam(':type_lic', $data['tipoLicenciatura'], PDO::PARAM_STR);
            $stmt->bindParam(':street', $data['calle'], PDO::PARAM_STR);
            $stmt->bindParam(':nInt', $data['numeroInterior'], PDO::PARAM_STR);
            $stmt->bindParam(':nExt', $data['numeroExterior'], PDO::PARAM_STR);
            $stmt->bindParam(':colony', $data['colonia'], PDO::PARAM_STR);
            $stmt->bindParam(':cp', $data['codigoPostal'], PDO::PARAM_STR);
            $stmt->bindParam(':dayBirthday', $data['diaNacimiento'], PDO::PARAM_INT);
            $stmt->bindParam(':monthBirthday', $data['mesNacimiento'], PDO::PARAM_INT);
            $stmt->bindParam(':yearBirthday', $data['anioNacimiento'], PDO::PARAM_INT);
            $stmt->bindParam(':gender', $data['genero'], PDO::PARAM_INT);

            if ($stmt->execute()) {
                return "success";
            } else {
                return "error";
            }
        }catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Código de error para entrada duplicada
                $response = "duplicate";
            } else {
                $response = "error";
            }
        }

        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    public static function mdlEditStudent($data) {
        try {
            $stmt = Conexion::conectar()->prepare("UPDATE student SET matricula = :matricula, firstname = :firstname, lastname = :lastname, idDegree = :idDegree, grado = :grado, email = :email, phone = :phone, emergenci_phone = :emergenci_phone, parent = :parent, type_lic = :type_lic, street = :street, nInt = :nInt, nExt = :nExt, colony = :colony, cp = :cp, dayBirthday = :dayBirthday, monthBirthday = :monthBirthday, yearBirthday = :yearBirthday, gender = :gender WHERE idStudent = :idStudent");
            
            $stmt->bindParam(':matricula', $data['matricula'], PDO::PARAM_STR);
            $stmt->bindParam(':firstname', $data['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $data['apellidos'], PDO::PARAM_STR);
            $stmt->bindParam(':idDegree', $data['licenciatura'], PDO::PARAM_INT);
            $stmt->bindParam(':grado', $data['grado'], PDO::PARAM_INT);
            $stmt->bindParam(':email', $data['correoInstitucional'], PDO::PARAM_STR);
            $stmt->bindParam(':phone', $data['telefonoContacto'], PDO::PARAM_STR);
            $stmt->bindParam(':emergenci_phone', $data['telefonoEmergencia'], PDO::PARAM_STR);
            $stmt->bindParam(':parent', $data['parentesco'], PDO::PARAM_STR);
            $stmt->bindParam(':type_lic', $data['tipoLicenciatura'], PDO::PARAM_STR);
            $stmt->bindParam(':street', $data['calle'], PDO::PARAM_STR);
            $stmt->bindParam(':nInt', $data['numeroInterior'], PDO::PARAM_STR);
            $stmt->bindParam(':nExt', $data['numeroExterior'], PDO::PARAM_STR);
            $stmt->bindParam(':colony', $data['colonia'], PDO::PARAM_STR);
            $stmt->bindParam(':cp', $data['codigoPostal'], PDO::PARAM_STR);
            $stmt->bindParam(':dayBirthday', $data['diaNacimiento'], PDO::PARAM_INT);
            $stmt->bindParam(':monthBirthday', $data['mesNacimiento'], PDO::PARAM_INT);
            $stmt->bindParam(':yearBirthday', $data['anioNacimiento'], PDO::PARAM_INT);
            $stmt->bindParam(':gender', $data['genero'], PDO::PARAM_INT);
            $stmt->bindParam(':idStudent', $data['idStudent'], PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return "success";
            } else {
                return "error update";
            }
        }catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Código de error para entrada duplicada
                $response = "duplicate";
            } else {
                $response = "error".$e->getCode();
            }
        }

        $stmt->closeCursor();
        $stmt = null;
        return $response;

    }
    
    static public function mdlSearchStudents($idStudent) {
        if ($idStudent == null) {
            $sql = "SELECT * FROM student s LEFT JOIN courses c ON c.idCourse = s.idCourse LEFT JOIN degrees d ON d.idDegree = s.idDegree";
            $stmt = Conexion::conectar()->prepare($sql);
            $stmt->execute();
            $response = $stmt->fetchAll();
        } else {
            $sql = "SELECT * FROM student s LEFT JOIN courses c ON c.idCourse = s.idCourse LEFT JOIN degrees d ON d.idDegree = s.idDegree WHERE s.idStudent = :idStudent";
            $stmt = Conexion::conectar()->prepare($sql);
            $stmt->bindParam(":idStudent", $idStudent, PDO::PARAM_STR);
            $stmt->execute();
            $response = $stmt->fetch();
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlAcceptStudent($idStudent) {
        $sql = "UPDATE student SET accepted = 1 WHERE idStudent = :idStudent";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":idStudent", $idStudent, PDO::PARAM_STR);
        
        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlDenegateStudent($idStudent) {
        $sql = "DELETE FROM student WHERE idStudent = :idStudent";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":idStudent", $idStudent, PDO::PARAM_STR);
        
        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlDropStudent($idStudent, $comments) {
        $sql = "UPDATE student SET status = 0, comments = :comments, password = '' WHERE idStudent = :idStudent";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":idStudent", $idStudent, PDO::PARAM_STR);
        $stmt->bindParam(":comments", $comments, PDO::PARAM_STR);
        
        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlAddPasswordStudent($cryptPass, $student) {
        $sql = "UPDATE student SET password = :password WHERE idStudent = :student";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":password", $cryptPass, PDO::PARAM_STR);
        $stmt->bindParam(":student", $student, PDO::PARAM_INT);
        
        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlGetStudent($email) {
        $sql = "SELECT * FROM student WHERE email = :email";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $response = $stmt->fetch();
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlAddDegree($data) {
        $sql = "INSERT INTO degrees (nameDegree, minPoints) VALUES (:nameDegree, :minPoints);";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":nameDegree", $data["nameDegree"], PDO::PARAM_STR);
        $stmt->bindParam(":minPoints", $data["minPoints"], PDO::PARAM_INT);
        
        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlSearchDegrees($idDegree) {
        if ($idDegree == null) {
            $sql = "SELECT * FROM degrees order by nameDegree asc";
            $stmt = Conexion::conectar()->prepare($sql);
            $stmt->execute();
            $response = $stmt->fetchAll();
        } else {
            $sql = "SELECT * FROM degrees WHERE idDegree = :idDegree";
            $stmt = Conexion::conectar()->prepare($sql);
            $stmt->bindParam(":idDegree", $idDegree, PDO::PARAM_INT);
            $stmt->execute();
            $response = $stmt->fetch();
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlSearchEvents($idEvent) {
        if ($idEvent == null) {
            $sql = "SELECT * FROM events ORDER BY dateEvent ASC";
            $stmt = Conexion::conectar()->prepare($sql);
            $stmt->execute();
            $response = $stmt->fetchAll();
        } else {
            $sql = "SELECT * FROM events WHERE idEvent = :idEvent";
            $stmt = Conexion::conectar()->prepare($sql);
            $stmt->bindParam(":idEvent", $idEvent, PDO::PARAM_INT);
            $stmt->execute();
            $response = $stmt->fetch();
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlStudentEvents($idEvent) {
        $sql = "SELECT SUM(1) AS students FROM students_events WHERE idEvent = :idEvent";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":idEvent", $idEvent, PDO::PARAM_INT);
        $stmt->execute();
        $response = $stmt->fetch();
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlEventsCandidates($idEvent) {
        $sql = "SELECT s.idStudent, s.firstname, s.lastname, s.email, s.phone, e.*, se.* FROM students_events se LEFT JOIN student s ON s.idStudent = se.idStudent LEFT JOIN events e ON e.idEvent = se.idEvent WHERE se.idEvent = :idEvent";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":idEvent", $idEvent, PDO::PARAM_INT);
        $stmt->execute();
        $response = $stmt->fetchAll();
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlUsersToAreas($idArea) {
        $sql = "SELECT 
                    u.id AS idUser, 
                    u.firstname, 
                    u.lastname, 
                    CASE 
                        WHEN (SELECT COUNT(*) FROM areas_users au WHERE au.idUser = u.id AND au.idArea = :idArea) > 0 THEN 1 
                        ELSE 0 
                    END AS pertenece
                FROM 
                    users u
                LEFT JOIN 
                    areas_users au ON u.id = au.idUser AND au.idArea = :idArea
                GROUP BY 
                    u.id;
                ";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":idArea", $idArea, PDO::PARAM_INT);
        $stmt->execute();
        $response = $stmt->fetchAll();
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlUpdateUsersToAreas($idArea, $idUser) {
        $sqlInsert = "INSERT INTO areas_users (idUser, idArea) VALUES (:idUser, :idArea) ON DUPLICATE KEY UPDATE idArea = :idArea";
        $stmtInsert = Conexion::conectar()->prepare($sqlInsert);
        $stmtInsert->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $stmtInsert->bindParam(":idArea", $idArea, PDO::PARAM_INT);

        if($stmtInsert->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }

        $stmtInsert->closeCursor();
        $stmtInsert = null;
        return $response;
    }

    static public function mdlSearchUsers($idUser) {
        if ($idUser == null) {
            $sql = "SELECT * FROM users ORDER BY firstname ASC";
            $stmt = Conexion::conectar()->prepare($sql);
            $stmt->execute();
            $response = $stmt->fetchAll();
        } else {
            $sql = "SELECT * FROM users WHERE id = :idUser";
            $stmt = Conexion::conectar()->prepare($sql);
            $stmt->bindParam(":idUser", $idUser, PDO::PARAM_INT);
            $stmt->execute();
            $response = $stmt->fetch();
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlAcceptCandidate($idStudent, $idEvent, $idUser) {
        $sql = "UPDATE students_events SET status = 1, idUser = :idUser, statusEvent = 1, points = 0 WHERE idStudent = :idStudent AND idEvent = :idEvent";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":idStudent", $idStudent, PDO::PARAM_INT);
        $stmt->bindParam(":idEvent", $idEvent, PDO::PARAM_INT);
        $stmt->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        
        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlDeclineCandidate($idStudent, $idEvent, $idUser) {
        $sql = "UPDATE students_events SET status = 2, idUser = :idUser, statusEvent = 0, points = 0 WHERE idStudent = :idStudent AND idEvent = :idEvent";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":idStudent", $idStudent, PDO::PARAM_INT);
        $stmt->bindParam(":idEvent", $idEvent, PDO::PARAM_INT);
        $stmt->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        
        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlGetPointsEvent($idEvent) {
        $sql = "SELECT points FROM events WHERE idEvent = :idEvent";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":idEvent", $idEvent, PDO::PARAM_INT);
        $stmt->execute();
        $response = $stmt->fetch();
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlApproveEvent($idStudent, $idEvent, $idUser, $points) {
        $sql = "UPDATE students_events 
                SET 
                    status = 2, 
                    idUser = :idUser, 
                    statusEvent = 1, 
                    points = :points, 
                    evaluationDate = DATE_SUB(NOW(), INTERVAL 6 HOUR) 
                WHERE 
                    idStudent = :idStudent 
                    AND idEvent = :idEvent;
                ";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":idStudent", $idStudent, PDO::PARAM_INT);
        $stmt->bindParam(":idEvent", $idEvent, PDO::PARAM_INT);
        $stmt->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $stmt->bindParam(":points", $points, PDO::PARAM_INT);
        
        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlDeclineEvent($idStudent, $idEvent, $idUser) {
        $sql = "UPDATE students_events SET status = 3, idUser = :idUser, statusEvent = 0, points = 0 WHERE idStudent = :idStudent AND idEvent = :idEvent";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":idStudent", $idStudent, PDO::PARAM_INT);
        $stmt->bindParam(":idEvent", $idEvent, PDO::PARAM_INT);
        $stmt->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        
        if($stmt->execute()) {
            $response = "success";
        } else {
            $response = "error";
        }
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlStudentEventsPoints($idStudent) {
        $sql = "SELECT se.points, se.idEvent, e.eventName, 
                (SELECT d.minPoints FROM degrees d LEFT JOIN student s ON s.idDegree = d.idDegree WHERE s.idStudent = :idStudent ) as minPoints
                    FROM students_events se 
                    LEFT JOIN events e ON e.idEvent = se.idEvent 
                WHERE se.idStudent = :idStudent AND se.statusEvent = 1";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":idStudent", $idStudent, PDO::PARAM_INT);
        $stmt->execute();
        $response = $stmt->fetchAll();
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }

    static public function mdlStudentPoints ($idStudent) {
        $sql = "SELECT 
                    SUM(se.points) as totalPoints,
                    (SELECT d.minPoints 
                    FROM degrees d 
                    LEFT JOIN student s ON s.idDegree = d.idDegree 
                    WHERE s.idStudent = :idStudent) as degreeMinPoints
                FROM 
                    students_events se 
                LEFT JOIN 
                    events e ON e.idEvent = se.idEvent 
                WHERE 
                    se.idStudent = :idStudent AND se.statusEvent = 1;";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(":idStudent", $idStudent, PDO::PARAM_INT);
        $stmt->execute();
        $response = $stmt->fetch();
        
        $stmt->closeCursor();
        $stmt = null;
        return $response;
    }
}
class FormsModelPDF {

    static public function mdlEndSocialService($student, $degree) {// Cargar el PDF original
        $pdf = new Fpdi();

        $numeroATexto = numeroATexto($student['grado']);
        $gradoAcademico = ($student['type_lic'] == 'cuatrimestral') ? $numeroATexto. ' cuatrimestre' : $numeroATexto. ' sementre';
        
        // Establecer márgenes más pequeños (0 para que no haya margen)
        $pdf->SetMargins(5, 5, 5); // Izquierdo, Superior, Derecho
        require_once __DIR__ . '/../vendor/autoload.php';

        // Cargar el archivo PDF original
        $pageCount = $pdf->setSourceFile(__DIR__ . '/../view/assets/documents/Formato_Solicitud-Registro-1.pdf');
        $templateId = $pdf->importPage(1);
        $size = $pdf->getTemplateSize($templateId);
        
        // Añadir una página con el tamaño exacto del contenido
        $pdf->AddPage($size['orientation'], array($size['width'], $size['height']));
        
        // Usar la plantilla del PDF original con las dimensiones correctas
        $pdf->useTemplate($templateId, 0, 0, $size['width'], $size['height']);
        
        // Configurar la fuente para el texto
        $pdf->SetFont('Helvetica', '', 7);
        
        // Llenar campos de texto con conversión a ISO-8859-1 para evitar problemas de codificación
        $pdf->SetXY(25, 43.5); // Coordenadas aproximadas del campo "Apellido Paterno"
        $pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', mb_strtoupper($student['lastname'])));
        
        $pdf->SetXY(72, 43.5); // Coordenadas aproximadas del campo "Apellido Materno"
        $pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', mb_strtoupper($student['lastnameMom'])));
        
        $pdf->SetXY(113, 43.5); // Coordenadas aproximadas del campo "Nombre"
        $pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', mb_strtoupper($student['firstname'])));
        
        $pdf->SetXY(25, 54); // Coordenadas aproximadas del campo "Calle y número"
        $pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', mb_strtoupper($student['street'] . ' ' . $student['nInt'] . ' ' . $student['nExt'])));
        
        $pdf->SetXY(72, 54); // Coordenadas aproximadas del campo "Colonia"
        $pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', mb_strtoupper($student['colony'])));
        
        $pdf->SetXY(113 , 54); // Coordenadas aproximadas del campo "Población"
        $pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', mb_strtoupper('Michoacán')));
        
        $pdf->SetXY(25, 64.5); // Coordenadas aproximadas del campo "Teléfono"
        $pdf->Write(0, $student['phone']);
        
        $pdf->SetXY(95, 64.5); // Coordenadas aproximadas del campo "correo"
        $pdf->Write(0, $student['email']);
        
        $pdf->SetXY(25, 71.8); // Coordenadas aproximadas del campo "Carrera"
        $pdf->Write(0, mb_strtoupper($degree['nameDegree']));
        
        $pdf->SetXY(166, 71.8); // Coordenadas aproximadas del campo "Año o semestre concluido"
        $pdf->Write(0, mb_strtoupper($gradoAcademico));
        
        $pdf->SetXY(54, 79); // Coordenadas aproximadas del campo "Nombre de la institución"
        $pdf->Write(0, 'UNIVERSIDAD MONTRER');
        
        $pdf->SetXY(174, 64.5); // Coordenadas aproximadas del campo "Dia"
        $pdf->Write(0, $student['dayBirthday']);
        
        $pdf->SetXY(184, 64.5); // Coordenadas aproximadas del campo "Més"
        $pdf->Write(0, $student['monthBirthday']);
        
        $pdf->SetXY(193, 64.5); // Coordenadas aproximadas del campo "Año"
        $pdf->Write(0, $student['yearBirthday']);
        
        $pdf->SetXY(25, 90); // Coordenadas aproximadas del campo "Datos del programa (NOMBRE)"
        $pdf->Write(0, 'PROGRAMA GENERAL DE SERVICIO SOCIAL DE UNIVERSIDAD MONTRER');
        
        $pdf->SetXY(58, 101); // Coordenadas aproximadas del campo "Datos del programa (ACTIVIDADES)"
        $pdf->Write(0, 'APOYO EN ACTIVIDADES ACADEMICAS');
        
        $pdf->SetXY(157, 112.5); // Coordenadas aproximadas del campo "Datos del programa (HORARIO)"
        $pdf->Write(0, '8:00 A 12:00 HRS.');
        
        $fechaInicio = new DateTime();

        // Clonar la fecha de inicio para obtener la fecha de término
        $fechaTermino = clone $fechaInicio;
        if ($degree['minPoints'] == 480) {
            $fechaTermino->modify('+6 months');
        } else {
            $fechaTermino->modify('+12 months');
        }

        // Escribir la fecha de inicio
        $pdf->SetXY(58, 116); // Coordenadas aproximadas del campo "Datos del programa (DÍA INICIO)"
        $pdf->Write(0, $fechaInicio->format('d'));

        $pdf->SetXY(69, 116); // Coordenadas aproximadas del campo "Datos del programa (MES INICIO)"
        $pdf->Write(0, $fechaInicio->format('m'));

        $pdf->SetXY(78, 116); // Coordenadas aproximadas del campo "Datos del programa (AÑO INICIO)"
        $pdf->Write(0, $fechaInicio->format('Y'));

        // Escribir la fecha de término
        $pdf->SetXY(111, 116); // Coordenadas aproximadas del campo "Datos del programa (DÍA TERMINO)"
        $pdf->Write(0, $fechaTermino->format('d'));

        $pdf->SetXY(121, 116); // Coordenadas aproximadas del campo "Datos del programa (MES TERMINO)"
        $pdf->Write(0, $fechaTermino->format('m'));

        $pdf->SetXY(130, 116); // Coordenadas aproximadas del campo "Datos del programa (AÑO TERMINO)"
        $pdf->Write(0, $fechaTermino->format('Y'));
        
        $pdf->SetXY(50, 124.5); // Coordenadas aproximadas del campo "Datos del programa (HORAS)"
        $pdf->Write(0, '480');
        
        $pdf->SetXY(145, 124.5); // Coordenadas aproximadas del campo "Datos del programa (HORAS)"
        $pdf->Write(0, 'UNIVERSIDAD MONTRER');
        
        $pdf->SetXY(52, 130); // Coordenadas aproximadas del campo "Datos del programa (HORAS)"
        $pdf->Write(0, 'UNIVERSIDAD MONTRER');
        
        $pdf->SetXY(38, 135.3); // Coordenadas aproximadas del campo "Datos del programa (HORAS)"
        $pdf->Write(0, 'SERVICIO SOCIAL');
        
        $pdf->SetXY(54, 140.3); // Coordenadas aproximadas del campo "Datos del programa (HORAS)"
        $pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', 'AV. LAZARO CARDENAS 1760'));
        
        $pdf->SetXY(98, 140.3); // Coordenadas aproximadas del campo "Datos del programa (HORAS)"
        $pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', 'CHAPULTEPEC SUR'));
        
        $pdf->SetXY(155, 140.3); // Coordenadas aproximadas del campo "Datos del programa (HORAS)"
        $pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', 'MORELIA, MICHOACÁN'));
        
        $pdf->SetXY(68, 151.3); // Coordenadas aproximadas del campo "Datos del programa (HORAS)"
        $pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', 'OSCAR LOPEZ GARCIA'));
        
        $pdf->SetXY(162.5, 179); // Coordenadas aproximadas del campo "Datos del programa (HORAS)"
        $pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', 'OSCAR LOPEZ GARCIA'));

        // Obtener la longitud del texto
        $texto = mb_strtoupper($student['firstname'] . ' ' . $student['lastname'] . ' ' . $student['lastnameMom'] . ' ');
        $textoConvertido = iconv('UTF-8', 'ISO-8859-1', $texto);

        // Calcular el ancho del texto en el PDF
        $anchoTexto = $pdf->GetStringWidth($textoConvertido);

        // Ancho de la página o del área donde deseas centrar
        $anchoPagina = 210; // Ancho de la página A4 en mm, por ejemplo
        $margenIzquierdo = 0; // Si tienes márgenes específicos

        // Calcular la posición X para centrar el texto
        $posicionX = ($anchoPagina - $anchoTexto) / 2 + $margenIzquierdo;

        // Escribir el texto centrado
        $pdf->SetXY($posicionX, 179); // Coordenadas Y especificadas
        $pdf->Write(0, $textoConvertido);

        
        // Configurar la fuente para el texto
        $pdf->SetFont('Helvetica', '', 5);
        
        $pdf->SetXY(23, 96); // Coordenadas aproximadas del campo "Datos del programa (OBJETIVO)"
        $pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', 'CONTRIBUIR EN LA FORMACION PROFESIONAL DE LOS ESTUDIANTES DEL ESTADO DE MICHOACAN A TRAVES DE LA CREACION DE ESPACIOS QUE LES PERMITAN INTEGRARSE A UN AMBIENTE DE TRABAJO'));
        
        // Usar la fuente ZapfDingbats para insertar una casilla de verificación
        $pdf->SetFont('ZapfDingbats','', 8);
        
        $pdf->SetXY(50, 157);
        $pdf->Write(0, '4'); 
        
        if ($student['gender'] == 2) {
            // Colocar la segunda casilla de verificación en una posición ajustada
            $pdf->SetXY(199, 44); // Coordenadas ajustadas para la casilla de verificación para "Sexo: F"
            $pdf->Write(0, '4'); // '4' en ZapfDingbats es una marca de verificación
        } else {
            // Colocar la primera casilla de verificación en la posición deseada
            $pdf->SetXY(190, 44); // Coordenadas aproximadas de la casilla de verificación para "Sexo: M"
            $pdf->Write(0, '4'); // '4' en ZapfDingbats es una marca de verificación
        }
            
        // Puedes agregar más campos de esta manera, ajustando las coordenadas
        // Guarda el nuevo archivo PDF
        $pdf->Output('F', __DIR__ . '/../view/assets/documents/output/'.$texto.'.pdf');
        return $texto.'.pdf'; // Devuelve el nombre del archivo PDF generado
        
    }
    
    static public function getAceptationCard($student, $degree) {
        
        $month = 6;
        $fechaInicio = new DateTime();
        $fechaTermino = clone $fechaInicio;

        if ($degree['minPoints'] == 480) {
            $month = 6;
            $fechaTermino->modify('+6 months');
        } else {
            $month = 12;
            $fechaTermino->modify('+12 months');
        }
        
        $numeroATexto = numeroATexto($student['grado']);
        $gradoAcademico = ($student['type_lic'] == 'cuatrimestral') ? $numeroATexto. ' cuatrimestre' : $numeroATexto. ' sementre';

        // Configurar la localización para fechas en español
        setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'Spanish_Spain');

        // Cargar el PDF original
        $pdf = new Fpdi();

        // Establecer márgenes más pequeños (0 para que no haya margen)
        $pdf->SetMargins(45, 5, 20); // Izquierdo, Superior, Derecho

        // Cargar el archivo PDF original
        $pageCount = $pdf->setSourceFile(__DIR__ . '/../view/assets/documents/Carta_aceptacion.pdf');
        $templateId = $pdf->importPage(1);
        $size = $pdf->getTemplateSize($templateId);

        // Añadir una página con el tamaño exacto del contenido
        $pdf->AddPage($size['orientation'], array($size['width'], $size['height']));

        // Usar la plantilla del PDF original con las dimensiones correctas
        $pdf->useTemplate($templateId, 0, 0, $size['width'], $size['height']);

        // Configurar la fuente para el texto
        $pdf->SetFont('Helvetica', '', 12);

        // Obtener la fecha actual en español
        $fechaEmision = strftime('%d de %B de %Y'); // Ejemplo: "22 de agosto de 2024"

        // Escribir la fecha
        $pdf->SetXY(10, 25);
        $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', "Morelia, Mich., a $fechaEmision."), 0, 1, 'R');

        // Escribir "Asunto:"
        $pdf->SetXY(99, 40);
        $pdf->Write(10, iconv('UTF-8', 'ISO-8859-1', 'Asunto: '));
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Write(10, iconv('UTF-8', 'ISO-8859-1', 'Carta de aceptación de Servicio Social.'));


        // Escribir DSS-CASS
        $pdf->SetXY(10, 50);
        $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', "DSS-CASS-004-2024 DD"), 0, 1, 'R');

        // Escribir los datos del destinatario
        $pdf->SetXY(45, 68);
        $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', "Lic. Luz Selene Archundia Sánchez"), 0, 1, 'L');
        $pdf->SetXY(45, 73);
        $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', "Subdirectora de Servicio Social y Pasantes"), 0, 1, 'L');
        $pdf->SetXY(45, 78);
        $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', "Instituto de la Juventud Michoacana"), 0, 1, 'L');

        // Escribir "Presente"
        $pdf->SetXY(45, 90);
        $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', "Presente"), 0, 1, 'L');

        // Restablecer la fuente normal
        $pdf->SetFont('Helvetica', '', 12);
        // Escribir el cuerpo de la carta
        $texto = mb_strtoupper($student['firstname'] . ' ' . $student['lastname'] . ' ' . $student['lastnameMom'] . ' ');

        $pdf->SetXY(45, 105);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', "En relación a la solicitud del alumno "));
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', $texto));
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', ", quien concluyó el "));
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', mb_strtoupper($gradoAcademico)));
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', " de la LICENCIATURA EN "));
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', mb_strtoupper($degree['nameDegree'])));
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', " de "));
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', "UNIVERSIDAD MONTRER"));
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', ", con número de matrícula "));
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', $student['matricula']));
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', ", me permito informarle que ha sido aceptado en este organismo receptor denominado: "));
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', "UNIVERSIDAD MONTRER"));
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', ", para realizar el "));
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', "SERVICIO SOCIAL"));
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', " y cubrir un total de "));
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', $degree['minPoints']));
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', " HORAS en un periodo de "));
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', $month .' MESES'));
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', " comprendido del "));
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', $fechaInicio->format('d')."/".$fechaInicio->format('m')."/".$fechaInicio->format('y')));
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', " al "));
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', $fechaTermino->format('d')."/".$fechaTermino->format('m')."/".$fechaTermino->format('y')));
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->Write(7, iconv('UTF-8', 'ISO-8859-1', ".

Sin otro asunto en particular, agradezco de antemano la atención que se sirva brindar a nuestros alumnos, enviándole un cordial saludo."));

        // Guardar el nuevo archivo PDF
        $filename = 'Carta_de_aceptacion_' . $texto . '.pdf';
        $pdf->Output('F', __DIR__ . '/../view/assets/documents/output/' . $filename);
        return $filename;
    }

}

function numeroATexto($numero) {
    $numerosEnTexto = [
        1 => 'Primero',
        2 => 'Segundo',
        3 => 'Tercero',
        4 => 'Cuarto',
        5 => 'Quinto',
        6 => 'Sexto',
        7 => 'Séptimo',
        8 => 'Octavo',
        9 => 'Noveno',
        10 => 'Décimo',
        11 => 'Undécimo',
        12 => 'Duodécimo'
    ];

    return isset($numerosEnTexto[$numero]) ? $numerosEnTexto[$numero] : $numero;
}

function mdlSendEmail($recipientEmail, $message) {
    // Asunto del correo
    $subject = "Nuevo Evento Disponible para Servicio Social";
    
    // Cabeceras del correo
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: no-reply@unimontrer.edu.mx" . "\r\n";
    
    
    // Enviar el correo
    mail($recipientEmail, $subject, $message, $headers);
}
