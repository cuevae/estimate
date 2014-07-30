<?php

require '../vendor/autoload.php';

use \CollectionPlusJson\Collection;
use \CollectionPlusJson\Item;
use \CollectionPlusJson\Util\Href;
use \CollectionPlusJson\Util\Parser\Item as ItemParser;
use \Estimate\App as Estimate;

const ENVIRONMENT      = 'development';
const SLIM_CONFIG_PATH = '../config/slim/app-config.json';

$configLoader = json_decode(file_get_contents(SLIM_CONFIG_PATH), true);
$appConfig    = $configLoader[ENVIRONMENT];

$app = new \Slim\Slim($appConfig);

$app->get(
    '/project/:projectId',
        function ($projectId) use ($app)
        {
            echo "This is project " . $projectId . PHP_EOL;
        }
);

$app->get(
    '/',
        function () use ($app)
        {

            $estimate = new Estimate();

            $projects = $estimate->getProjects();

            $collection = new Collection(new Href('http://api.estimate.io/'));

            if (isset($projects) && is_array($projects) && !empty($projects))
            {
                $itemParser = new ItemParser();
                $collection->addItems($itemParser->parseManyFromArray($projects));
            }

            /*$color1 = new Item($collection->getHref()->extend('colors/color1'));
            $color1->addData('id', '1', 'This is the color id')
                   ->addData('hex_value', '#9932CC', 'This is the color in hex format')
                   ->addData('human_value', 'DarkOrchid', 'This is the color in human readable format');

            $color2 = new Item($collection->getHref()->extend('colors/color2'));
            $color2->addData('id', '2', 'This is the color id')
                   ->addData('hex_value', '#FFFFF0', 'This is the color in hex format')
                   ->addData('human_value', 'Ivory', 'This is the color in human readable format');


            $collection->addItem($color1)->addItem($color2);*/

            /**
             * RESPONSE HEADERS
             */
            $app->response->headers->set('Content-Type', 'application/vnd.collection+json');

            /**
             * RESPONSE STATUS
             */
            $app->response->status(200);

            echo json_encode($collection->output());

        }
);

$app->run();