<?php

use Estimate\Project;

class ProjectTest extends \PHPUnit_Framework_TestCase
{

    /** @var  \Estimate\Project */
    protected $project;

    protected function setUp()
    {
        $this->project = new Project('Test', date('Y-m-d', strtotime('+1month')));
    }

    public function testCreateNewProject()
    {
        $date    = date('Y-m-d', strtotime('+1week'));
        $name    = 'Join the A-Team';
        $project = new Project($name, $date);
        $this->assertEquals($name, $project->getName());
        $this->assertEquals($date, $project->getDueDate());
    }

    public function testPersistentVersionReturnsStdClassObject()
    {
        $obj = $this->project->getPersistentVersion();
        $this->assertInstanceOf('\StdClass', $obj);
    }

} 
