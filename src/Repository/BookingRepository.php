<?php

namespace App\Repository;

use App\Entity\Booking;
use PDO;

class BookingRepository
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=127.0.0.1;dbname=booking', 'suser', 'spass');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM booking');
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($booking) {
            return new Booking($booking['id'], $booking['lesson_id'], $booking['student_id']);
        }, $bookings);
    }

    public function find($id): ?Booking
    {
        $stmt = $this->pdo->prepare('SELECT * FROM booking WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$booking) {
            return null;
        }

        return new Booking($booking['id'], $booking['lesson_id'], $booking['student_id']);
    }

    public function create($lessonId, $studentId): Booking
    {
        $stmt = $this->pdo->prepare('INSERT INTO booking (lesson_id, student_id) VALUES (:lesson_id, :student_id)');
        $stmt->execute(['lesson_id' => $lessonId, 'student_id' => $studentId]);

        return new Booking($this->pdo->lastInsertId(), $lessonId, $studentId);
    }

    public function update($id, $lessonId, $studentId): Booking
    {
        $stmt = $this->pdo->prepare('UPDATE booking SET lesson_id = :lesson_id, student_id = :student_id WHERE id = :id');
        $stmt->execute(['id' => $id, 'lesson_id' => $lessonId, 'student_id' => $studentId]);

        return new Booking($id, $lessonId, $studentId);
    }

    public function delete($id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM booking WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function checkLessonCapacity($lessonId): bool
    {
        $stmt = $this->pdo->prepare('SELECT capacity FROM lesson WHERE id = :lesson_id');
        $stmt->execute(['lesson_id' => $lessonId]);
        $lesson = $stmt->fetch(PDO::FETCH_ASSOC);

        return $lesson && $lesson['capacity'] > 0;
    }

    public function reduceLessonCapacity($lessonId): void
    {
        $stmt = $this->pdo->prepare('UPDATE lesson SET capacity = capacity - 1 WHERE id = :lesson_id');
        $stmt->execute(['lesson_id' => $lessonId]);
    }

    public function restoreLessonCapacity($lessonId): void
    {
        $stmt = $this->pdo->prepare('UPDATE lesson SET capacity = capacity + 1 WHERE id = :lesson_id');
        $stmt->execute(['lesson_id' => $lessonId]);
    }

    public function findLesson($lessonId): ?array
    {
        $stmt = $this->pdo->prepare('SELECT date, start_time, end_time FROM lesson WHERE id = :lesson_id');
        $stmt->execute(['lesson_id' => $lessonId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkExistingBooking($studentId, $lesson): int
    {
        $stmt = $this->pdo->prepare('
            SELECT COUNT(*) FROM booking b
            JOIN lesson l ON b.lesson_id = l.id
            WHERE b.student_id = :student_id
            AND l.date = :date
            AND (
                (l.start_time <= :end_time AND l.end_time >= :start_time)
            )
        ');

        $stmt->execute([
            'student_id' => $studentId,
            'date' => $lesson['date'],
            'start_time' => $lesson['start_time'],
            'end_time' => $lesson['end_time'],
        ]);

        return $stmt->fetchColumn();
    }
}
