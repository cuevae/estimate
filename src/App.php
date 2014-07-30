<?php

namespace Estimate;

class App
{

    public function __construct()
    {

    }

    public function getProjectsRaw()
    {
        return array(
            array( 'id' => 'abc123', 'hash' => '', 'name' => 'Test project 1', 'due_date' => '1608897600' ),
            array( 'id' => '2sdf31', 'hash' => '', 'name' => 'Test project 2', 'due_date' => '1608984000' ),
            array( 'id' => '3sd2xc', 'hash' => '', 'name' => 'Test project 3', 'due_date' => '1609070400' ),
        );
    }

    public function getProjects()
    {
        $raw    = $this->getProjectsRaw();
        $result = array_reduce($raw, function ($result, $item)
        {
            $temp = array(
                array( 'id', $item['id'], 'Project id.' ),
                array( 'name', $item['name'], 'Project name.' ),
                array( 'due_date_ts', $item['due_date'], 'Project due date timestamp.' ),
                array( 'due_date_hr', date('Y-m-d H:i:s', $item['due_date']), 'Project due date human readable "YYYY-MM-DD HH:MM:SS".' )
            );
            $result[] = $temp;
        }, array());

        return $result;
    }

} 