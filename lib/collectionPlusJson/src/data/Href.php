<?php
/**
 * Created by PhpStorm.
 * User: manei
 * Date: 27/06/14
 * Time: 19:37
 */

namespace CollectionPlusJson\Data;


class Href {

    /** @var  string */
    protected $uri;

    const URI_REGEXP = '#^http://api.estimate.(local|com)$#';

    /**
     * @param $uri
     * @throws \Exception
     */
    public function __construct( $uri )
    {
        if ( preg_match( self::URI_REGEXP, $uri ) == false ) {
            throw new \Exception( 'Invalid URI' );
        }
        $this->uri = $uri;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function _output()
    {
        return $this->getUri();
    }

} 