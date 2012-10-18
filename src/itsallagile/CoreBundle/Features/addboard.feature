Feature: Adding a Board
  In order start a new sprint
  As a user
  I need to be able create a new board

  Scenario: Add Board
    Given I am an authenticated user
    When I add a new board called "Behat Board"
    Then I should see "Behat Board"
