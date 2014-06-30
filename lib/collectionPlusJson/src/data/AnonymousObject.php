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
        $this->prompt = $prompt;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool|int|string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getPrompt()
    {
        return $this->prompt;
    }

    /**
     * @return \StdClass
     */
    public function _output()
    {
        $properties = get_object_vars($this);
        $object = new \StdClass();
        foreach ( $properties as $name => $value ) {
            $object->$name = $value;
        }
        return $object;
    }

} 