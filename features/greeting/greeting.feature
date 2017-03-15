Feature: Customer greeting
  In order to be interactive webpage
  As a customer
  I want to greeted by the webpage

  Rules:
  - Before 10 am it says: Good Morning!
  - After 10 am, but before 8 pm it says: Hello!
  - After 8 pm it says: Good Night!

  Scenario: Visiting the webpage in the morning
    Given the time is "07:30"
    When I visit the webpage
    Then The webpage says "Good Morning!"
  Scenario: Visiting the webpage daytime
    Given the time is "11:30"
    When I visit the webpage
    Then The webpage says "Hello!"
  Scenario: Visiting the webpage in the evening
    Given the time is "20:30"
    When I visit the webpage
    Then The webpage says "Good Evening!"

  Scenario Outline: Visiting the webpage
    Given the time is <visit_time>
    When I visit the webpage
    Then The webpage says <greeting>
    Examples:
      |visit_time|greeting|
      |"09:59"   |"Good Morning!"|
      |"10:00"   |"Hello!"|
      |"19:59"   |"Hello!"|
      |"20:00"   |"Good Evening!"|
      |"23:59"   |"Good Evening!"|
      |"00:01"   |"Good Evening!"|
      |"05:00"   |"Good Morning!"|