Feature: Project management

  As a Developer I'd like to manage my projects (CRUD)

#  Scenario Outline: Creating a project successfully
#    Given I know the end point for projects
#    And I send a PUT request with a project name <name> and due_date <date>
#    Then I should receive 201 response code
#    And I should receive content type application/vnd.collection+json
#    And header Location should contain http://estimate.test/projects/1
#    And body should contain a link to http://estimate.test/projects/1
#
#  Examples:
#    | name | date              |
#    | Test | 1/2/2014          |
#    | Test | 1-2-2014          |
#    | Test | 1st February 2014 |


  Scenario: Getting the list of available projects
    Given I know the end point for projects
    And I send a GET request
    Then I should receive 200 response code
    And I should receive content type application/vnd.collection+json
    #And header Location should contain http://estimate.test/projects/
    #And body should contain a link to http://estimate.test/projects/

#  Scenario: Updating a project
#    Given I know the url for a specific project with name "name" and due date "date"
#    And I send a PUT request with a new name and a new due date
#    Then I should receive a 200 response code
#    And I should receive content type <type>
#    And I should receive the canonical url to the new resource in the Location header
#    And I should receive a description and a link to the new resource in the Body
#
#  Scenario: Deleting a project
#    Given I know the url for a specific project with name "name" and due date "date"
#    And I send a DELETE request
#    Then I should receive a 200 OK status
#    Then I try accessing the resource again
#    And I should receive a 404 Not Found
