<?php

require '../vendor/autoload.php';

use \CollectionPlusJson\Collection;
use \CollectionPlusJson\Item;
use \CollectionPlusJson\Util\Href;
use \CollectionPlusJson\DataObject;

const ENVIRONMENT = 'development';
const SLIM_CONFIG_PATH = '../config/slim/app-config.json';

$configLoader = json_decode(file_get_contents(SLIM_CONFIG_PATH), true);
$appConfig = $configLoader[ENVIRONMENT];

$app = new \Slim\Slim($appConfig);

$app->get(
    '/project/:projectId',
        function ($projectId) use ($app) {


        }
);

$app->get(
    '/',
        function () use ($app) {

            $app->response->headers->set('Content-Type', 'application/vnd.collection+json');

            $project1 = new Item(new Href('http://api.estimate.local/project/1'));
            $project1->addData(
                     new DataObject('name',
                                    'Project Test',
                                    'This is the Project Name'))
                     ->addData(
                     new DataObject('due_date_ts',
                                    strtotime('+1month'),
                                    'This is the project due date specified in UNIX timestamp, seconds since epoch'))
                     ->addData(
                     new DataObject('due_date_human',
                                    date('Y-m-d H:i:s', strtotime('+1month')),
                                    'This is the project due date in human readable format'));

            $project2 = new Item(new Href('http://api.estimate.local/project/2'));
            $project2
                ->addData(new DataObject('name',
                                         'Wololo',
                                         'This is the Project Name'))
                ->addData(new DataObject('due_date_ts',
                                         strtotime('+1week'),
                                         'This is the project due date specified in UNIX timestamp, seconds since epoch'))
                ->addData(new DataObject('due_date_human',
                                         date('Y-m-d H:i:s', strtotime('+1week')),
                                         'This is the project due date in human readable format'));

            $collection = new Collection('0.0.1', new Href('/'));
            $collection->addItem($project1)->addItem($project2);

            $response = new StdClass();
            $response->collection = $collection->_output();

            echo json_encode($response);

        }
);

$app->run();