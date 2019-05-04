Feature: As a connected user, I must be able to access the home page.

  Scenario: [Fail] If I am redirected to the login page if I am not connected.
    Given I am on "/"
    Then I should be on "/login"

  Scenario: [Success] If I am connected, then I should be able to access to home page and I should see the main title.
    Given I am on "/"
    And I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/"
    Then I should be on "/"
    And I should see "Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !"

  Scenario: [Success] If I am connected and click on the "Créer un utilisateur" link, then I should be redirected to the user creation page.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/"
    And I follow "Créer un utilisateur"
    Then I should be on "/users/create"

  Scenario: [Success] If I am connected and click on the "Se déconnecter" link, then I should be redirected to the login page.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/"
    And I follow "Se déconnecter"
    Then I should be on "/login"

  Scenario: [Success] If I am connected and click on the "Créer une nouvelle tâche" link, then I should be redirected to the task create page.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/"
    And I follow "Créer une nouvelle tâche"
    Then I should be on "/tasks/create"

  Scenario: [Success] If I am connected and click on the "Consulter la liste des tâches à faire" link, then I should be redirected to the tasks list page.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/"
    And I follow "Consulter la liste des tâches à faire"
    Then I should be on "/tasks"

  Scenario: [Success] If I am connected and click on the "Consulter la liste des tâches terminées" link, then I should be redirected to the home page.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/"
    And I follow "Consulter la liste des tâches terminées"
    Then I should be on "/"