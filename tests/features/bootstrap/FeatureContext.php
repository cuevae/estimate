<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
    }

    /**
     * @Given /^I know the end point for ([a-z]+)$/
     */
    public function iKnowTheEndPointFor($resource)
    {
        throw new PendingException();
    }

    /**
     * @Given /^I send a (GET|POST|PUT|DELETE|HEAD) request with a project name (.+) and due_date (.+)$/
     */
    public function iSendARequestWithAProjectNameAndADueDate($request, $name, $date)
    {
        throw new PendingException();
    }

    /**
     * @Then /^I should receive a (\d+) ([a-zA-Z\s]+) status$/
     */
    public function iShouldReceiveAStatus($code, $text)
    {
        throw new PendingException();
    }

    /**
     * @Given /^header (.+) should contain the canonical url for the resource$/
     */
    public function headerShouldContainTheCanonicalUrlForTheResource($header)
    {
        throw new PendingException();
    }

    /**
     * @Given /^body should contain a link to the resource$/
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
