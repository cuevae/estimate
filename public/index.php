<?php

require '../vendor/autoload.php';

use \CollectionPlusJson\Collection;
use \CollectionPlusJson\Util\Href;
use \CollectionPlusJson\Util\Parser\Item as ItemParser;
use \Estimate\App as Estimate;

const ENVIRONMENT      = 'development';
const SLIM_CONFIG_PATH = '../config/slim/app-config.json';

$configLoader = json_decode(file_get_contents(SLIM_CONFIG_PATH), true);
$appConfig    = $configLoader[ENVIRONMENT];

/** @var \Slim\Slim $app */
$app = new \Slim\Slim($appConfig);

$app->get(
    '/',
        function () use ($app)
        {
            $url = new Href( $app->request()->getUrl() );

            $collection = new Collection( $url );
            $estimate = new Estimate();

            $projects = $estimate->getProjects();
            $projects = array_reduce( $projects, function($result, $item) use( $url ){
                $temp = array('href' => $url->extend('/project/' . $item['id'])->getUrl(),
                              'data' => array( array( 'id', $item['id'], 'Project id.' ),
                                               array( 'name', $item['name'], 'Project name.' ),
                                               array( 'due_date_ts', $item['due_date'], 'Project due date timestamp.' ),
                                               array( 'due_date_hr', date('Y-m-d H:i:s', $item['due_date']),
                                                      'Project due date human readable "YYYY-MM-DD HH:MM:SS".' )
                              ));
                $result[] = $temp;
                return $result;
            }, array());

            if (isset($projects) && is_array($projects) && !empty($projects))
            {
                $itemParser = new ItemParser();
                $collection->addItems($itemParser->parseManyFromArray($projects));
            }

            $app->response->headers->set('Content-Type', 'application/vnd.collection+json');
            $app->response->status(200);

            echo json_encode($collection->output());
        }
);

$app->get(
    '/project/:projectId',
        function ($projectId) use ($app)
        {
            echo "This is project " . $projectId . PHP_EOL;
        }
);

$app->run();