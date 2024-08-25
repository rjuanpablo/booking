<?php

namespace App\Repository;

use App\Entity\Student;
use PDO;

class StudentRepository
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=127.0.0.1;dbname=booking', 'suser', 'spass');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM student');
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($student) {
            return new Student($student['id'], $student['name']);
        }, $students);
    }

    public function find($id): ?Student
    {
        $stmt = $this->pdo->prepare('SELECT * FROM student WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$student) {
            return null;
        }

        return new Student($student['id'], $student['name']);
    }

    public function create($name): Student
    {
        $stmt = $this->pdo->prepare('INSERT INTO student (name) VALUES (:name)');
        $stmt->execute(['name' => $name]);

        return new Student($this->pdo->lastInsertId(), $name);
    }

    public function update($id, $name): Student
    {
        $stmt = $this->pdo->prepare('UPDATE student SET name = :name WHERE id = :id');
        $stmt->execute([
            'id' => $id,
            'name' => $name,
        ]);

        return new Student($id, $name);
    }

    public function delete($id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM student WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
