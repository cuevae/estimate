<?php
/**
 * Created by PhpStorm.
 * User: manei
 * Date: 27/06/14
 * Time: 19:20
 */

namespace CollectionPlusJson;


class Query
{

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