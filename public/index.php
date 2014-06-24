<?php

require '../vendor/autoload.php';

const ENVIRONMENT = 'development';
const SLIM_CONFIG_PATH = 'config/slim/app-config.json';

$configLoader = json_decode( file_get_contents( SLIM_CONFIG_PATH ), true );
$appConfig = $configLoader[ENVIRONMENT];

$app = new \Slim\Slim( $appConfig );

$app->get( '/hello/:name', function ( $name ) {
    echo "Hello, $name";
} );

$app->run();