<?php

require '../vendor/autoload.php';

use \CollectionPlusJson\Collection;
use \CollectionPlusJson\Item;
use \CollectionPlusJson\Data;
use \CollectionPlusJson\Data\Href;
use \CollectionPlusJson\Data\AnonymousObject;

const ENVIRONMENT = 'development';
const SLIM_CONFIG_PATH = '../config/slim/app-config.json';

$configLoader = json_decode( file_get_contents( SLIM_CONFIG_PATH ), true );
$appConfig = $configLoader[ENVIRONMENT];

$app = new \Slim\Slim( $appConfig );

$app->get( '/project/:projectId', function ( $projectId ) use ( $app ) {


} );

$app->get( '/', function () use ( $app ) {

    $app->response->headers->set( 'Content-Type', 'application/vnd.collection+json' );

    $project1 =
        new Item(
            new Href( 'http://api.estimate.local/project/1' ),
            new Data(
                new AnonymousObject(
                    'name',
                    'Project Test',
                    'This is the Project Name'
                ),
                new AnonymousObject(
                    'due_date_ts',
                    strtotime( '+1month' ),
                    'This is the project due date specified in UNIX timestamp, seconds since epoch'
                ),
                new AnonymousObject(
                    'due_date_human',
                    date( 'Y-m-d H:i:s', strtotime( '+1month' ) ),
                    'This is the project due date in human readable format'
                )
            )
        );

    $project2 =
        new Item(
            new Href( 'http://api.estimate.local/project/2' ),
            new Data(
                new AnonymousObject(
                    'name',
                    'Wololo',
                    'This is the Project Name'
                ),
                new AnonymousObject(
                    'due_date_ts',
                    strtotime( '+1week' ),
                    'This is the project due date specified in UNIX timestamp, seconds since epoch'
                ),
                new AnonymousObject(
                    'due_date_human',
                    date( 'Y-m-d H:i:s', strtotime( '+1week' ) ),
                    'This is the project due date in human readable format'
                )
            )
        );

    $collection = new Collection();
    $collection->version = '0.0.1';
    $collection->href = '/';
    $collection->links = array();
    $collection->items = array( $project1, $project2 );
    $collection->queries = array();
    $collection->template = new StdClass();
    $collection->error = new StdClass();

    $template = new StdClass();
    $template->data = array();

    $response = new StdClass();
    $response->collection = $collection->_output();

    echo json_encode( $response );

} );

$app->run();