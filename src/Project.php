<?php


namespace Estimate;


use Estimate\Persistence\PersistentObject;

class Project extends PersistentObject
{

    protected $name;
    protected $dueDate;

    public function __construct($name, $dueDate)
    {
        $this->name = $name;
        $this->dueDate = $dueDate;
    }

    public function getPersistentVersion()
    {
        $obj = new \StdClass();
        $obj->name = $this->name;
        $obj->due_date = $this->dueDate;

        $time = time();
        $obj->savedOn = $time;
        $obj->savedOnHr = date('Y-m-d H:i:s', $time);

        return $obj;
    }
}