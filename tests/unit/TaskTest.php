<?php

use \Estimate\Task;

class TaskTest extends \PHPUnit_Framework_TestCase
{

    protected $task;

    protected function setUp()
    {
        $this->task = new Task('Test', 1, 6, 3);
    }

    public function testCreateNewTask()
    {
        $name                = 'Meet Murdock';
        $optimisticEstimate  = 1;
        $pessimisticEstimate = 10;
        $nominalEstimate     = 3;
        $task                = new Task($name, $optimisticEstimate, $pessimisticEstimate, $nominalEstimate);
        $this->assertEquals($name, $task->getName());
        $this->assertEquals($optimisticEstimate, $task->getOptimisticEstimate());
        $this->assertEquals($pessimisticEstimate, $task->getPessimisticEstimate());
        $this->assertEquals($nominalEstimate, $task->getNominalEstimate());
    }

} 