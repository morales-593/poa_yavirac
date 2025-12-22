<?php

class Usuario {

    /* ==========================
       LOGIN
    ========================== */
    public static function login($usuario, $password) {
        $db = Database::connect();

        $sql = "SELECT * FROM usuarios 
                WHERE usuario = ? AND estado = 'ACTIVO' 
                LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->execute([$usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    /* ==========================
       LISTAR
    ========================== */
    public static function getAll($search = '') {
        $db = Database::connect();

        $sql = "SELECT id_usuario, nombres, usuario, estado FROM usuarios";
        $params = [];

        if (!empty($search)) {
            $sql .= " WHERE nombres LIKE ? OR usuario LIKE ?";
            $search = "%$search%";
            $params = [$search, $search];
        }

        $sql .= " ORDER BY id_usuario ASC";

        $stmt = $db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ==========================
       OBTENER POR ID
    ========================== */
    public static function getById($id) {
        $db = Database::connect();

        $stmt = $db->prepare(
            "SELECT id_usuario, nombres, usuario, estado 
             FROM usuarios WHERE id_usuario = ?"
        );

        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* ==========================
       CREAR
    ========================== */
    public static function create($data) {
        $db = Database::connect();

        $sql = "INSERT INTO usuarios (nombres, usuario, password, estado)
                VALUES (?, ?, ?, ?)";

        $stmt = $db->prepare($sql);

        return $stmt->execute([
            $data['nombres'],
            $data['usuario'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['estado']
        ]);
    }

    /* ==========================
       ACTUALIZAR
    ========================== */
    public static function update($id, $data) {
        $db = Database::connect();

        if (!empty($data['password'])) {
            $sql = "UPDATE usuarios 
                    SET nombres = ?, usuario = ?, password = ?, estado = ?
                    WHERE id_usuario = ?";
            $params = [
                $data['nombres'],
                $data['usuario'],
                password_hash($data['password'], PASSWORD_DEFAULT),
                $data['estado'],
                $id
            ];
        } else {
            $sql = "UPDATE usuarios 
                    SET nombres = ?, usuario = ?, estado = ?
                    WHERE id_usuario = ?";
            $params = [
                $data['nombres'],
                $data['usuario'],
                $data['estado'],
                $id
            ];
        }

        $stmt = $db->prepare($sql);
        return $stmt->execute($params);
    }

    /* ==========================
       ELIMINAR (LÓGICO)
    ========================== */
    public static function delete($id) {
        $db = Database::connect();

        $stmt = $db->prepare(
            "UPDATE usuarios SET estado = 'INACTIVO' WHERE id_usuario = ?"
        );

        return $stmt->execute([$id]);
    }
}
