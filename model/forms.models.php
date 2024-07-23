<?php
include "conection.php";

class FormsModel {
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
    
}
