<?php

namespace App\Entity;

class Classroom
{
    private $id;
    private $name;
    private $capacity;

    public function __construct($id = null, $name = null, $capacity = null)
    {
        $this->id = $id;
        $this->name = $name;
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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
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