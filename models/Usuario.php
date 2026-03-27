<?php

require_once __DIR__ . '/../config/database.php';

class Usuario {
    private PDO $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM usuarios ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(string $nombre, string $apellido, string $correo, ?string $celular): int {
        $stmt = $this->db->prepare(
            "INSERT INTO usuarios (nombre, apellido, correo, celular) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$nombre, $apellido, $correo, $celular]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, string $nombre, string $apellido, string $correo, ?string $celular): bool {
        $stmt = $this->db->prepare(
            "UPDATE usuarios SET nombre = ?, apellido = ?, correo = ?, celular = ? WHERE id = ?"
        );
        return $stmt->execute([$nombre, $apellido, $correo, $celular, $id]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function emailExists(string $email, ?int $excludeId = null): bool {
        if ($excludeId) {
            $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE correo = ? AND id != ?");
            $stmt->execute([$email, $excludeId]);
        } else {
            $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE correo = ?");
            $stmt->execute([$email]);
        }
        return (bool)$stmt->fetch();
    }
}