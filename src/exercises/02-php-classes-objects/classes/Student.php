<?php


class Student{
    protected $name;
    protected $number;

    public function __construct($Name, $Number) {
        $this->name = $Name;
        $this->number = $Number;
    }

    public function getName() {
        return $this->name;
    }

    public function getNumber() {
        return $this->number;
    }
}

