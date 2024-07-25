<?php
include "conection.php";

class FormsModel {
    
// Users
    
    static public function mdlRegisterUser($table, $data) {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $table (firstname, email, password, role) VALUES (:firstname, :email, :password, :role)");
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
        $stmt = Conexion::conectar()->prepare("SELECT id, firstname, lastname, email, role, created_at FROM $table WHERE $item = :$item");
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
        $stmt = Conexion::conectar()->prepare("SELECT * FROM events");
        $stmt->execute();
        $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    static public function mdlGetCourses() {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM courses");
        $stmt->execute();
        $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    
}
