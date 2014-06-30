<?php

class DataTest extends PHPUnit_Framework_TestCase
{

    public function testConstructorHandleMultipleObjectsAsAguments()
    {
        $obj1 = new \CollectionPlusJson\Data\AnonymousObject( 'name', 't1', 'Test object 1' );
        $obj2 = new \CollectionPlusJson\Data\AnonymousObject( 'name', 't2', 'Test object 2' );
        $obj3 = new \CollectionPlusJson\Data\AnonymousObject( 'name', 't3', 'Test object 3' );

        //Zero objects
        $data0 = new \CollectionPlusJson\Data();
        $this->assertEmpty( $data0->getObjects() );

        //One object
        $data1 = new \CollectionPlusJson\Data( $obj1 );
        $this->assertCount( 1, $data1->getObjects() );
        $this->assertEquals( $obj1, $data1->getObjects()[0] );

        //Two objects
        $data2 = new \CollectionPlusJson\Data( $obj3, $obj2 );
        $this->assertCount( 2, $data2->getObjects() );
        $this->assertEquals( $obj3, $data2->getObjects()[0] );
        $this->assertEquals( $obj2, $data2->getObjects()[1] );
    }

    /**
     * @expectedException \Exception
     */
    public function throwsExceptionWithNonValidObject()
    {
        $data = new \CollectionPlusJson\Data( new \StdClass() );
    }

    public function testAddObject()
    {
        $data = new \CollectionPlusJson\Data();

        $obj1 = new \CollectionPlusJson\Data\AnonymousObject( 'test_property', 'test_value', 'This is a test property' );
        $data->addObject( $obj1 );
        $objects = $data->getObjects();
        $this->assertCount(1, $objects);
        $this->assertEquals($obj1, $objects[0]);

        $obj2 = new \CollectionPlusJson\Data\AnonymousObject( 'test_property2', 'test_value2', 'This is a test property 2' );
        $data->addObject( $obj2 );
        $objects = $data->getObjects();
        $this->assertCount(2, $objects);
        $this->assertEquals($obj2, $objects[1]);
    }


    public function testOutput()
    {
        $obj1 = new \CollectionPlusJson\Data\AnonymousObject( 'test_property', 'test_value', 'This is a test property' );
        $obj2 = new \CollectionPlusJson\Data\AnonymousObject( 'test_property2', 'test_value2', 'This is a test property 2' );

        $data = new \CollectionPlusJson\Data( $obj1, $obj2 );

        $output = $data->_output();
        $this->assertTrue(is_array($output));
        $this->assertCount(2, $output);
    }

} 