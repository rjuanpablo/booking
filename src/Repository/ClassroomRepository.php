<?php

namespace App\Repository;

use App\Entity\Classroom;
use PDO;

class ClassroomRepository
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=127.0.0.1;dbname=booking', 'suser', 'spass');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM classroom');
        $classrooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($classroom) {
            return new Classroom($classroom['id'], $classroom['name'], $classroom['capacity']);
        }, $classrooms);
    }

    public function find($id): ?Classroom
    {
        $stmt = $this->pdo->prepare('SELECT * FROM classroom WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $classroom = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$classroom) {
            return null;
        }

        return new Classroom($classroom['id'], $classroom['name'], $classroom['capacity']);
    }

    public function create($name, $capacity): Classroom
    {
        $stmt = $this->pdo->prepare('INSERT INTO classroom (name, capacity) VALUES (:name, :capacity)');
        $stmt->execute(['name' => $name, 'capacity' => $capacity]);

        return new Classroom($this->pdo->lastInsertId(), $name, $capacity);
    }

    public function update($id, $name, $capacity): Classroom
    {
        $stmt = $this->pdo->prepare('UPDATE classroom SET name = :name, capacity = :capacity WHERE id = :id');
        $stmt->execute([
            'id' => $id,
            'name' => $name,
            'capacity' => $capacity,
        ]);

        return new Classroom($id, $name, $capacity);
    }

    public function delete($id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM classroom WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}