<?php
/**
 * Created by PhpStorm.
 * User: manei
 * Date: 27/06/14
 * Time: 19:15
 */

namespace CollectionPlusJson\Data;

/**
 *
 * Class AnonymousObject
 * @package CollectionPlusJson\Data
 *
 * Anonymous data object
 *
 */
class AnonymousObject {

    /** @var  string */
    protected $name;

    /** @var  int|string|bool */
    protected $value;

    /** @var  string */
    protected $prompt;

    public function __construct( $name, $value, $prompt = '')
    {
        $this->name = $name;
        $this->value = $value;
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