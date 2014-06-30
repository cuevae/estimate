<?php

class AnonymousObjectTest extends PHPUnit_Framework_TestCase
{

    protected function buildTestObject()
    {
        $name = 'test_property';
        $value = 'test_value';
        $prompt = 'This is a test property';

        $object = new \CollectionPlusJson\Data\AnonymousObject( $name, $value, $prompt );

        return $object;
    }

    public function testConstructingAnonymousObject()
    {
        $object = $this->buildTestObject();

        $this->assertEquals( 'test_property', $object->getName() );
        $this->assertEquals( 'test_value', $object->getValue() );
        $this->assertEquals( 'This is a test property', $object->getPrompt() );
    }

    public function testOutput()
    {
        $object = $this->buildTestObject();
        $output = $object->_output();

        $this->assertTrue( is_object( $output ) );
        $this->assertCount( 3, get_object_vars( $output ) );
        $this->assertObjectHasAttribute( 'name', $output );
        $this->assertObjectHasAttribute( 'value', $output );
        $this->assertObjectHasAttribute( 'prompt', $output );
        $this->assertInstanceOf( '\StdClass', $output );
    }

} 