<?php
/**
 * Created by PhpStorm.
 * User: manei
 * Date: 27/06/14
 * Time: 18:40
 */

namespace CollectionPlusJson;

class Collection
{

    /** @var string */
    protected $version;

    /** @var  string */
    protected $href;

    /** @var  array */
    protected $links;

    /** @var  array */
    protected $items;

    /** @var  array */
    protected $queries;

    /** @var  Template */
    protected $template;

    /** @var  Error */
    protected $error;


    public function __set( $attribute, $value )
    {
        if ( property_exists( $this, $attribute ) ) {
            $this->$attribute = $value;
        } else {
            throw new \Exception( 'Property ' . $attribute . ' does not exists in object ' . __CLASS__ );
        }
    }

    public function __get( $attribute )
    {
        if ( property_exists( $this, $attribute ) ) {
            return $this->$attribute;
        } else {
            throw new \Exception( 'Property ' . $attribute . ' does not exists in object ' . __CLASS__ );
        }
    }

    public function _output()
    {
        $properties = get_object_vars($this);
        $object = new \StdClass();
        foreach ( $properties as $name => $value ) {
            if( is_array($value) ){
                foreach($value as &$val ){
                    if(is_object($val)){
                        $val = $val->_output();
                    }
                }
            }
            if( is_object( $value ) && ! $value instanceof \StdClass ){
                $value = $value->_output();
            }
            $object->$name = $value;
        }
        return $object;
    }

} 