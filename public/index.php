<?php

require __DIR__ . '/../vendor/autoload.php';

use \CollectionPlusJson\Collection;
use \CollectionPlusJson\Util\Parser\Item as ItemParser;
use \Estimate\App as Estimate;

const ENVIRONMENT      = 'development';
const SLIM_CONFIG_PATH = '../config/slim/app-config.json';

class EndPoint
{
    const ROOT     = '/';
    const PROJECTS = '/';
    const PROJECT  = '/projects/:projectId';
    const TASKS    = '/projects/:projectId/tasks';
    const TASK     = '/projects/:projectId/tasks/:taskId';

    /**
     * @param $projectId
     *
     * @return string
     */
    public static function forProject($projectId)
    {
        return str_replace(':projectId', $projectId, static::PROJECT);
    }
}

$configLoader = json_decode(file_get_contents(__DIR__ . '/' . SLIM_CONFIG_PATH), true);
$appConfig    = $configLoader[ENVIRONMENT];
/** @var \Slim\Slim $app */
$app = new \Slim\Slim($appConfig);

$app->get(
    EndPoint::PROJECTS,
        function () use ($app)
        {

            $collection = new Collection($app->request()->getUrl());
            $estimate   = new Estimate();

            $projects = $estimate->getProjects();
            if (is_array($projects) && !empty($projects))
            {
                $projects = array_reduce($projects, function ($result, $item)
                {

                    $temp     = array( 'href' => EndPoint::forProject($item['id']),
                                       'data' => array( array( 'id', $item['id'], 'Project id.' ),
                                                        array( 'name', $item['name'], 'Project name.' ),
                                                        array( 'due_date_ts', $item['due_date'], 'Project due date timestamp.' ),
                                                        array( 'due_date_hr', date('Y-m-d H:i:s', $item['due_date']),
                                                               'Project due date human readable "YYYY-MM-DD HH:MM:SS".' )
                                       ) );
                    $result[] = $temp;

                    return $result;
                }, array());
            }

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

$app->put(
    EndPoint::PROJECTS,
        function () use ($app)
        {
            $name    = $app->request->put('name');
            $dueDate = $app->request->put('due_date');

            $estimate = new Estimate();

            try
            {
                $projectId = $estimate->addProject($name, $dueDate);
                $projectUrl = $app->request->getUrl() . EndPoint::forProject($projectId);
                $app->response->header('Location', $projectUrl);
                $app->response->status(201);
            } catch (\Exception $e)
            {
                $app->response->status(400);
                echo($e->getMessage());
            }

            echo $projectUrl;
        }
);

$app->get(
    EndPoint::PROJECT,
        function ($projectId) use ($app)
        {
            $collection = new Collection($app->request()->getUrl());

            $app->response->headers->set('Content-Type', 'application/vnd.collection+json');
            $app->response->status(200);

            echo json_encode($collection->output());
        }
);

$app->run();