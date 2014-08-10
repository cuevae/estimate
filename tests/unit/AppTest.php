<?php

use \Estimate\App as EstimateApp;

class AppTest extends PHPUnit_Framework_TestCase
{

    /** @var EstimateApp */
    protected $app;

    protected function setUp()
    {
        $this->app = new EstimateApp();
    }

} 
