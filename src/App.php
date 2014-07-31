<?php

namespace Estimate;

use \Estimate\Project;

class App
{

    protected $persistenceHandler;

    public function __construct(PersintenceHandler $persintenceHandler = null)
    {

    }

    public function getProjects()
    {
        $projects = array();
        if(isset($this->persistenceHandler)){
            $projects = $this->persistenceHandler->load('\Estimate\Project');
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
            $this->persistenceHandler->save($project);
        }

    }

} 