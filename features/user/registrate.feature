Feature: User registration
  In order remeber my data and to protect it with username and password
  As a user
  I want to register a new account

  Rules:
  - Loginname must be minimum 3 characters long
  - Password can't be empty
  - If a loginname is reserved it can't be registered again

  Scenario: Success registration
    Given a user base where "norbi" loginname hasn't registered yet
    When the user "Csizmarik Norbert" tries to register with "norbi" loginname and "secret" password
    Then the registration is "success"

  Scenario: Unsuccess registration - reserved login name
    Given a registered user with "norbi" loginname and "secret" password
    When the user "Csizmarik Norbert" tries to register with "norbi" loginname and "secret" password
    Then the registration is "failed"

  Scenario: Unsuccess registration - too short loginname
    Given a user base where "norbi" loginname hasn't registered yet
    When the user "Csizmarik Norbert" tries to register with "no" loginname and "secret" password
    Then the registration is "failed"