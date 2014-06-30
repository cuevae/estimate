<?php
/**
 * Created by PhpStorm.
 * User: manei
 * Date: 27/06/14
 * Time: 19:45
 */

namespace CollectionPlusJson;

use \CollectionPlusJson\Data\AnonymousObject;

class Data implements \Iterator
{

    /** @var  AnonymousObject[] */
    protected $objects = array();

    /**
     * You can pass as many anonymous objects as you want or add them later
     */
    public function __construct()
    {
        $args = func_get_args();
        foreach ( $args as $object ) {
            if ( !$object instanceof AnonymousObject ) {
                throw new \Exception( 'Given argument is not instance of \CollectionPlusJson\Data\AnonymousObject' );
            }
            $this->objects[] = $object;
        }
    }

    /**
     * @param AnonymousObject $object
     */
    public function addObject( AnonymousObject $object )
    {
        $this->objects[] = $object;
    }

    /**
     * @return array
     */
    public function getObjects()
    {
        return $this->objects;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return current( $this->$objects );
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        next( $this->$objects );
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return key( $this->objects );
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        $current = $this->current();
        return isset( $current );
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        reset( $this->objects );
    }

    /**
     * @return array
     */
    public function _output()
    {
        $objects = $this->objects ? : array();
        foreach ( $objects as &$val ) {
            $val = $val->_output();
        }
        return $objects;
    }
}