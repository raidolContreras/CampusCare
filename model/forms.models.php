<?php
include "conection.php";

class FormsModel {
    static public function mdlRegisterEvent($data) {
        $stmt = Conexion::conectar()->prepare("INSERT INTO events (name, type, points) VALUES (:name, :type, :points)");
        $stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
        $stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
        $stmt->bindParam(":points", $data["points"], PDO::PARAM_INT);
        return $stmt->execute();
    }

    static public function mdlRegisterUser($table, $data) {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $table (name, email, password, role) VALUES (:name, :email, :password, :role)");
        $stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
        $stmt->bindParam(":email", $data["email"], PDO::PARAM_STR);
        $stmt->bindParam(":password", $data["password"], PDO::PARAM_STR);
        $stmt->bindParam(":role", $data["role"], PDO::PARAM_STR);
        return $stmt->execute();
    }

    static public function mdlGetUsers() {
        $stmt = Conexion::conectar()->prepare("SELECT id, name, email, role, created_at FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function mdlShowUser($table, $item, $value) {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $table WHERE $item = :$item");
        $stmt->bindParam(":" . $item, $value, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    static public function mdlGradeStudent($data) {
        $stmt = Conexion::conectar()->prepare("UPDATE students SET points = points + :points WHERE id = :id");
        $stmt->bindParam(":points", $data["points"], PDO::PARAM_INT);
        $stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
        return $stmt->execute();
    }
    
}
