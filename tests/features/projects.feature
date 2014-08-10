Feature: Project management

  As a Developer I'd like to manage my projects (CRUD)

  Scenario: Creating a project successfully
    Given I know the end point for projects
    And I send a PUT request with a project name <name> and due_date <date>
    Then I should receive a 201 Created status
    And header Location should contain the canonical url for the resource
    And body should contain a link to the resource

  Scenario: Getting the list of available projects
    Given I know the end point for projects
    And I send a GET request
    Then I should receive a 200 OK status
    And I should receive the project url

  Scenario: Updating a project
    Given I know the url for a specific project with name "name" and due date "date"
    And I send a PUT request with a new name and a new due date
    Then I should receive a 200 OK status
    And I should receive the canonical url to the new resource in the Location header
    And I should receive a description and a link to the new resource in the Body

  Scenario: Deleting a project
    Given I know the url for a specific project with name "name" and due date "date"
    And I send a DELETE request
    Then I should receive a 200 OK status
    Then I try accessing the resource again
    And I should receive a 404 Not Found
