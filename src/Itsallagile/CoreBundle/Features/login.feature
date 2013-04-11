Feature: Login
  In order to see features specific to me
  As a user
  I need to be able to log in

  Scenario: Login      
    Given I have an account
    When I log in     
    Then I should see "Dashboard"
