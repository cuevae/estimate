<?php

namespace CollectionPlusJson;

use \CollectionPlusJson\Data;
use \CollectionPlusJson\Data\Href;


class Item
{

    /** @var  Href */
    protected $href;

    /** @var  Data */
    protected $data;

    /** @var  array */
    protected $links;

    public function __construct( Href $href, Data $data = null, array $links = null )
    {
        $this->href = $href;
        if ( isset( $data ) && $data instanceof Data ) {
            $this->data = $data;
        }
        if ( isset( $links ) && is_array( $links ) ) {
            $this->links = $links;
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