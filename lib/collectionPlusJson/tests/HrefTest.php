<?php

class HrefTest extends PHPUnit_Framework_TestCase{

    /**
     * @expectedException \Exception
     */
    public function testThrowsExceptionWithInvalidUrl()
    {
        $uri = new \CollectionPlusJson\Data\Href('http:/api.estimate.local');
    }

    public function testGetUri()
    {
        $endPoint = 'http://api.estimate.local';
        $uri = new \CollectionPlusJson\Data\Href( $endPoint );
        $this->assertEquals($endPoint, $uri->getUri());
    }

    public function testOutput()
    {
        $endPoint = 'http://api.estimate.local';
        $uri = new \CollectionPlusJson\Data\Href( $endPoint );
        $output = $uri->_output();
        $this->assertTrue(is_string($output));
        $this->assertEquals($endPoint, $output);
    }

} 