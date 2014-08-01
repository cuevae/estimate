<?php


namespace Estimate;


class Project
{

    protected $name;
    protected $dueDate;

    public function __construct($name, $dueDate)
    {
        $this->name = $name;
        $this->dueDate = $dueDate;
    }

} 