<?php

namespace Estimate;

class App
{

    public function getProjects()
    {
        return array(
            array( 'id' => 'abc123', 'hash' => '', 'name' => 'Test project 1', 'due_date' => '1608897600' ),
            array( 'id' => '2sdf31', 'hash' => '', 'name' => 'Test project 2', 'due_date' => '1608984000' ),
            array( 'id' => '3sd2xc', 'hash' => '', 'name' => 'Test project 3', 'due_date' => '1609070400' ),
        );
    }

} 