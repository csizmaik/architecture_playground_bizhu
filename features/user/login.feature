Feature: User login
  In order to identify the visitors
  As a user
  I want to login with a username and password

  Rules:
  - User can login with a good loginname and password pairs
  - If a user deactivated it can't login
  - If a user tries to login with the wrong password 3 times it can't login afterward

  Scenario: Success login
    Given a registered user with "norbi" loginname and "secret" password
    When "norbi" user tries to login with "secret" password
    Then the login is "success"

  Scenario: Unsuccess login - wrong password
    Given a registered user with "norbi" loginname and "secret" password
    When "norbi" user tries to login with "wrongpass" password
    Then the login is "failed"

  Scenario: Unsuccess login - deactivated user login
    Given a registered user with "norbi" loginname and "secret" password
    And "norbi" user is deactivated
    When "norbi" user tries to login with "secret" password
    Then the login is "failed"

  Scenario: Unsuccess login - try after 3 failed authentication
    Given a registered user with "norbi" loginname and "secret" password
    When "norbi" user tries to login with "wrongpass" password
    And "norbi" user tries to login with "wrongpass" password
    And "norbi" user tries to login with "wrongpass" password
    And "norbi" user tries to login with "secret" password
    Then the login is "failed"

  Scenario: Success login - 3 failed authentication then reset counter
    Given a registered user with "norbi" loginname and "secret" password
    When "norbi" user tries to login with "wrongpass" password
    And "norbi" user tries to login with "wrongpass" password
    And "norbi" user tries to login with "wrongpass" password
    And reset unsuccess login counter for "norbi" user
    And "norbi" user tries to login with "secret" password
    Then the login is "success"
