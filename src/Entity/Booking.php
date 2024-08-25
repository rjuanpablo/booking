<?php

namespace App\Entity;

class Booking
{
    private $id;
    private $lessonId;
    private $studentId;

    public function __construct($id = null, $lessonId = null, $studentId = null)
    {
        $this->id = $id;
        $this->lessonId = $lessonId;
        $this->studentId = $studentId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getLessonId()
    {
        return $this->lessonId;
    }

    public function setLessonId($lessonId)
    {
        $this->lessonId = $lessonId;
    }

    public function getStudentId()
    {
        return $this->studentId;
    }

    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;
    }
}