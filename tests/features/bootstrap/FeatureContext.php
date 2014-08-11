<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{

    protected $endpoints = array(
        'projects' => 'http://estimate.test/projects'
    );

    protected $endpoint = null;
    protected $testPort = null;
    protected $info = null;
    protected $response = null;

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        $this->testPort = $parameters['test_port'];
    }

    /**
     * @Given /^I know the end point for (.*)$/
     */
    public function iKnowTheEndPointFor($resource)
    {
        if (!isset($this->endpoints[$resource]))
        {
            throw new \Exception(sprintf('Resource %s has no defined endpoint.', $resource));
        }
        $this->endpoint = $this->endpoints[$resource];
    }

    /**
     * @Given /^I send a GET request$/
     */
    public function iSendAGetRequest()
    {
        if (!isset($this->endpoint))
        {
            throw new \Exception('There\'s no current endpoint selected.');
        }
        $ch = curl_init($this->endpoint);
        curl_setopt_array($ch, array(
            CURLOPT_HEADER         => true,
            CURLOPT_HTTPGET        => true,
            CURLOPT_RETURNTRANSFER => true,
        ));

        if (isset($this->testPort))
        {
            curl_setopt($ch, CURLOPT_PORT, $this->testPort);
        }

        $result = curl_exec($ch);
        if (false === $result)
        {
            throw new \Exception(sprintf('The request could not be performed. Error: %s', curl_error($ch)));
        }

        $this->response = $result;
        $this->info     = curl_getinfo($ch);
        curl_close($ch);
    }

    /**
     * @Given /^I send a (GET|POST|PUT|DELETE|HEAD) request with a project name (.+) and due_date (.+)$/
     */
    public function iSendARequestWithAProjectNameAndADueDate($request, $name, $date)
    {
        throw new PendingException();
    }

    /**
     * @Then /^I should receive (\d+) response code$/
     */
    public function iShouldReceiveResponseCode($code)
    {
        if (!isset($this->info))
        {
            throw new \Exception('There\'s no registered output. Please ensure the request was successful.');
        }

        assertEquals($code, $this->info['http_code']);
    }

    /**
     * @Given /^I should receive content type (.*)$/
     */
    public function iShouldReceiveContentType($type)
    {
        if (!isset($this->info))
        {
            throw new \Exception('There\'s no registered output. Please ensure the request was successful.');
        }

        assertEquals($type, $this->info['content_type']);
    }

    /**
     * @Given /^header (.*) should contain (.*)$/
     */
    public function headerShouldContain($header, $content)
    {
        if (!isset($this->info))
        {
            throw new \Exception('There\'s no registered output. Please ensure the request was successful.');
        }

        $expected = $header . ': ' . $content;

        list($headers) = explode("\r\n\r\n", $this->response);
        $parts = explode("\n", $headers);
        $found = false;
        while (current($parts) && !$found)
        {
            $found = (current($parts) == $expected);
            next($parts);
        }

        if(!$found){
            throw new \Exception(sprintf('Expected header "%s" not found.', $expected));
        }
    }

    /**
     * @Given /^body should contain a link to (.*)$/
     */
    public function bodyShouldContainALinkToTheResource()
    {
        throw new PendingException();
    }

    //
    // Place your definition and hook methods here:
    //
    //    /**
    //     * @Given /^I have done something with "([^"]*)"$/
    //     */
    //    public function iHaveDoneSomethingWith($argument)
    //    {
    //        doSomethingWith($argument);
    //    }
    //
}
