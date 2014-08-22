<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

require_once __DIR__ . '/../../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{

    protected $endpoints = array(
        'projects' => '{SERVER}/',
        'an_existing_project' => '{SERVER}/projects/1'
    );

    protected $server = null;
    protected $port = null;
    protected $endpoint = null;
    protected $response = null;
    protected $responseHeaders = null;
    protected $responseBody = null;
    protected $info = null;

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     *
     * @throws Exception
     */
    public function __construct(array $parameters)
    {
        if (!isset($parameters['test_server']))
        {
            throw new \Exception('Please specify a test server in behat.yml file.');
        }
        $this->server = $parameters['test_server'];
        $this->port   = $parameters['test_port'];

        //Update the endpoints with the given server name
        array_walk($this->endpoints, function (&$item, $key)
        {
            $item = str_replace('{SERVER}', $this->server, $item);
        });
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
        $request = $this->buildRequest('GET');
        $this->sendRequest($request);
    }

    /**
     * @Given /^I send a PUT request with a project name (.+) and due_date (.+)$/
     */
    public function iSendAPutRequestWithAProjectNameAndADueDate($name, $dueDate)
    {
        $ch = $this->buildRequest('PUT', array('name' => $name, 'due_date' => $dueDate));
        $this->sendRequest($ch);
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
        if (!isset($this->responseHeaders))
        {
            throw new \Exception('There\'s no registered response headers. Please ensure the request was successful.');
        }

        if (strpos($content, '{SERVER}') !== false)
        {
            $server  = (isset($this->port)
                ? ($this->server . ':' . $this->port)
                : ($this->server)
            );
            $content = str_replace('{SERVER}', $server, $content);
        }

        $expected = $header . ': ' . $content;
        $parts    = explode("\n", $this->responseHeaders);
        $found    = false;
        while (current($parts) && !$found)
        {
            $found = (current($parts) == $expected);
            next($parts);
        }

        if (!$found)
        {
            var_dump($this->responseHeaders);
            throw new \Exception(sprintf('Expected header "%s" not found.', $expected));
        }
    }

    /**
     * Returns TRUE if an object complies with the collection+json structure
     *
     * @param $obj
     *
     * @return bool
     */
    protected function isCollectionObject($obj)
    {
        return ($obj instanceof \StdClass)
               && property_exists($obj, 'collection')
               && property_exists($obj->collection, 'version')
               && property_exists($obj->collection, 'href')
               && property_exists($obj->collection, 'links')
               && property_exists($obj->collection, 'items')
               && property_exists($obj->collection, 'queries')
               && property_exists($obj->collection, 'template')
               && property_exists($obj->collection, 'error');
    }

    /**
     * @Given /^body should contain a collection\+json object$/
     */
    public function bodyShouldContainACollectionJsonObject()
    {
        if (!isset($this->responseBody))
        {
            throw new \Exception('There\'s no registered response body. Please ensure the request was successful.');
        }

        $jsonObj = json_decode($this->responseBody);
        if (!$this->isCollectionObject($jsonObj))
        {
            throw new \Exception('The given object does not comply with the collection+json structure.');
        }
    }

    /**
     * @Given /^body should contain a link to (.*)$/
     */
    public function bodyShouldContainALinkTo($link)
    {
        if (!isset($this->responseBody))
        {
            throw new \Exception('There\'s no registered response body. Please ensure the request was successful.');
        }

        if (strpos($link, '{SERVER}') !== false)
        {
            $server = (isset($this->port)
                ? ($this->server . ':' . $this->port)
                : ($this->server)
            );
            $link   = str_replace('{SERVER}', $server, $link);
        }

        assertEquals($link, $this->responseBody);
    }


    /**
     * Builds and HTTP request
     *
     * @param       $type
     * @param array $params
     *
     * @return resource
     * @throws Exception
     */
    protected function buildRequest($type, array $params = array())
    {
        if (!isset($this->endpoint))
        {
            throw new \Exception('There\'s no current endpoint selected.');
        }
        $ch = curl_init($this->endpoint);
        curl_setopt_array($ch, array(
            CURLOPT_HEADER         => true,
            CURLOPT_CUSTOMREQUEST  => $type,
            CURLOPT_RETURNTRANSFER => true,
        ));

        if (!empty($params))
        {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }

        if (isset($this->port))
        {
            curl_setopt($ch, CURLOPT_PORT, $this->port);
        }

        return $ch;
    }

    /**
     * Sends the given request
     *
     * @param $ch
     *
     * @throws Exception
     */
    protected function sendRequest($ch)
    {
        if (gettype($ch) != 'resource')
        {
            throw new \Exception('Expected resource to be able to send request.');
        }

        $result = curl_exec($ch);
        if (false === $result)
        {
            throw new \Exception(sprintf('The request could not be performed. Error: %s', curl_error($ch)));
        }

        $this->response = $result;
        $this->info     = curl_getinfo($ch);
        list($headers, $body) = explode("\r\n\r\n", $this->response, 2);
        $this->responseHeaders = $headers;
        $this->responseBody    = $body;
        curl_close($ch);
    }

}
