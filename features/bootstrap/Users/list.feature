Feature: As a connected user, I must be able to access the users list page.

  Scenario: [Fail] If I am not connected, then I should be redirected to the login page.
    Given I am on "/users"
    Then I should be on "/login"

  Scenario: [Success] If I am connected, then I can access the users list.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/users"
    Then I should be on "/users"

  Scenario: [Success] If I am connected, then I should see the users list.
    Given I load users in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/users"
    Then I should see "JohnDoe"
    And I should see "JaneDoe"

  Scenario: [Success] If I am connected and click on the "Créer un utilisateur" link, then I should be redirected to the user creation page.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/users"
    And I follow "Créer un utilisateur"
    Then I should be on "/users/create"

  Scenario: [Success] If I am connected and click on the "Se déconnecter" link, then I should be redirected to the login page.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/users"
    And I follow "Se déconnecter"
    Then I should be on "/login"