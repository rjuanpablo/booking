<?php

namespace App\Entity;

class Lesson
{
    private $id;
    private $classroomId;
    private $startTime;
    private $endTime;
    private $date;
    private $capacity;

    public function __construct($id = null, $classroomId = null, $startTime = null, $endTime = null, $date = null, $capacity = null)
    {
        $this->id = $id;
        $this->classroomId = $classroomId;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->date = $date;
        $this->capacity = $capacity;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getClassroomId()
    {
        return $this->classroomId;
    }

    public function setClassroomId($classroomId)
    {
        $this->classroomId = $classroomId;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }

    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getCapacity()
    {
        return $this->capacity;
    }

    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }
}
