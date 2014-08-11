<?php

use \Estimate\App as EstimateApp;

class AppTest extends \PHPUnit_Framework_TestCase
{

    /** @var EstimateApp */
    protected $app;

    protected function setUp()
    {
        $this->app = new EstimateApp();
    }

    public function testGetProjectsReturnsArray()
    {
        $projects = $this->app->getProjects();
        $this->assertTrue(is_array($projects));
    }

} 
