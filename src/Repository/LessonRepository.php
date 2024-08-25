<?php

namespace App\Repository;

use PDO;

class LessonRepository
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=127.0.0.1;dbname=booking', 'suser', 'spass');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('
            SELECT l.id, l.classroom_id, l.start_time, l.end_time, l.date, l.capacity, c.name AS classroom_name
            FROM lesson l
            JOIN classroom c ON l.classroom_id = c.id
            WHERE l.capacity > 0
        ');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM lesson WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $lesson = $stmt->fetch(PDO::FETCH_ASSOC);

        return $lesson ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO lesson (classroom_id, start_time, end_time, date, capacity) VALUES (:classroom_id, :start_time, :end_time, :date, :capacity)');
        $stmt->execute([
            'classroom_id' => $data['classroom_id'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'date' => $data['date'],
            'capacity' => $data['capacity'],
        ]);

        return $this->pdo->lastInsertId();
    }

    public function update($id, array $data): bool
    {
        $stmt = $this->pdo->prepare('UPDATE lesson SET classroom_id = :classroom_id, start_time = :start_time, end_time = :end_time, date = :date, capacity = :capacity WHERE id = :id');
        return $stmt->execute([
            'id' => $id,
            'classroom_id' => $data['classroom_id'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'date' => $data['date'],
            'capacity' => $data['capacity'],
        ]);
    }

    public function delete($id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM lesson WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function findClassroomCapacity($classroomId): ?int
    {
        $stmt = $this->pdo->prepare('SELECT capacity FROM classroom WHERE id = :classroom_id');
        $stmt->execute(['classroom_id' => $classroomId]);
        $classroom = $stmt->fetch(PDO::FETCH_ASSOC);

        return $classroom ? $classroom['capacity'] : null;
    }
}
