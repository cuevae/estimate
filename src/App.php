<?php

namespace Estimate;

use \Estimate\Persistence\HandlerInterface as PersintenceHandler;

class App
{

    /** @var \Estimate\Persistence\HandlerInterface  */
    protected $persistenceHandler;

    public function __construct(PersintenceHandler $persintenceHandler = null)
    {
        $this->persistenceHandler = $persintenceHandler;
    }

    public function getProjects()
    {
        $projects = array();
        if(isset($this->persistenceHandler)){
            $projects = $this->persistenceHandler->get('*');
        }

        return $projects;
    }

    public function addProject($name, $dueDate)
    {
        try{
            $project = new Project($name, $dueDate);
        } catch( \Exception $e ){
            throw new \Exception('Project could not be added: ' . $e->getMessage() );
        }

        if(isset($this->persistenceHandler)){
            $this->persistenceHandler->put($project);
        }

        $projectId = 1;

        return $projectId;
    }

} 