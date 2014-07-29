<?php

require '../vendor/autoload.php';

use \CollectionPlusJson\Collection;
use \CollectionPlusJson\Util\Href;

const ENVIRONMENT = 'development';
const SLIM_CONFIG_PATH = '../config/slim/app-config.json';

$configLoader = json_decode(file_get_contents(SLIM_CONFIG_PATH), true);
$appConfig = $configLoader[ENVIRONMENT];

$app = new \Slim\Slim($appConfig);

$app->get(
    '/project/:projectId',
        function ($projectId) use ($app) {
            echo "This is project " . $projectId . PHP_EOL;
        }
);

$app->get(
    '/',
        function () use ($app) {

            $app->response->headers->set('Content-Type', 'application/vnd.collection+json');

            $baseUrl = new Href('http://api.test.io/');
            $collection = new Collection($baseUrl);

            echo json_encode($collection->output());

        }
);

$app->run();