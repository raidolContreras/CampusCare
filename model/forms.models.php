<?php
include "conection.php";

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
        $stmt = Conexion::conectar()->prepare("SELECT * FROM events e LEFT JOIN event_types et ON et.idEventType = e.eventTypeId ");
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

    static public function mdlAddEvent($eventTypeId, $eventName, $date, $location, $start_time, $end_time, $points, $vacancies_available, $description) {
        $stmt = Conexion::conectar()->prepare("
            INSERT INTO events 
            (eventTypeId, eventName, date, location, start_time, end_time, points, vacancies_available, description, createdAt, idCourse) 
            VALUES 
            (:eventTypeId, :eventName, :date, :location, :start_time, :end_time, :points, :vacancies_available, :description, NOW(), (SELECT idCourse FROM courses WHERE active = 1))
        ");
    
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
            $stmt = Conexion::conectar()->prepare("INSERT INTO student(matricula, firstname, lastname, idDegree, grado, email, phone, emergenci_phone, parent, type_lic, street, nInt, nExt, colony, cp, dayBirthday, monthBirthday, yearBirthday, gender, idCourse) VALUES (:matricula, :firstname, :lastname, :idDegree, :grado, :email, :phone, :emergenci_phone, :parent, :type_lic, :street, :nInt, :nExt, :colony, :cp, :dayBirthday, :monthBirthday, :yearBirthday, :gender, (SELECT idCourse FROM courses WHERE active = 1))");
            
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
            $sql = "SELECT * FROM student s LEFT JOIN courses c ON c.idCourse = s.idCourse LEFT JOIN degrees d ON d.idDegree = s.idDegree WHERE c.active = 1";
            $stmt = Conexion::conectar()->prepare($sql);
            $stmt->execute();
            $response = $stmt->fetchAll();
        } else {
            $sql = "SELECT * FROM student s LEFT JOIN courses c ON c.idCourse = s.idCourse LEFT JOIN degrees d ON d.idDegree = s.idDegree WHERE s.idStudent = :idStudent AND c.active = 1";
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
        $sql = "SELECT s.*, e.* FROM students_events se LEFT JOIN student s ON s.idStudent = se.idStudent LEFT JOIN events e ON e.idEvent = se.idEvent WHERE se.idEvent = :idEvent";
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
    // Primero, elimina cualquier relación existente para este idUser
    $sqlDelete = "DELETE FROM areas_users WHERE idUser = :idUser";
    $stmtDelete = Conexion::conectar()->prepare($sqlDelete);
    $stmtDelete->bindParam(":idUser", $idUser, PDO::PARAM_INT);
    $stmtDelete->execute();

    // Luego, inserta la nueva relación
    $sqlInsert = "INSERT INTO areas_users (idUser, idArea) VALUES (:idUser, :idArea) ON DUPLICATE KEY UPDATE idUser = :idUser, idArea = :idArea";
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


}