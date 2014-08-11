<?php


namespace Estimate;


use Estimate\Persistence\PersistentObject;

class Project extends PersistentObject
{

    /** @var string */
    protected $name;

    /** @var  string */
    protected $dueDate;

    /**
     * @param $name
     * @param $dueDate
     */
    public function __construct($name, $dueDate)
    {
        $this->name = $name;
        $this->dueDate = $dueDate;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @return \StdClass
     */
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