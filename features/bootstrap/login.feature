Feature: As a unregistered user, I must be able to access the login page.

  Scenario: [Fail] If I do not fill in the form fields, an error message appears.
    Given I am on "/login"
    When I press "Se connecter"
    Then I should be on "/login"
    And I should see "Invalid credentials."

  Scenario: [Fail] If I am already connected, I am redirected to the home page.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/login"
    Then I should be on "/"

  Scenario: [Success] I log into my account and I am redirected to the home page.
    Given I load a user in database
    And I am on "/login"
    And I fill in "JohnDoe" for "username"
    And I fill in "12345678" for "password"
    And I press "Se connecter"
    Then I should be on "/"

  Scenario: [Success] If I am connected and click on the "Créer un utilisateur" link, then I should be redirected to the user creation page.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I follow "Créer un utilisateur"
    Then I should be on "/users/create"