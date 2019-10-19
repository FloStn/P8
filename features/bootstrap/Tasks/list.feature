Feature: As a connected user, I must be able to access the tasks list page.

  Scenario: [Fail] If I am not connected, then I should be redirected to the login page.
    Given I am on "/tasks"
    Then I should be on "/login"

  Scenario: [Success] If I am connected, then I can access the tasks list.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks"
    Then I should be on "/tasks"

  Scenario: [Success] If I'm connected and there are no tasks, then I should see "Il n'y a pas encore de tâche enregistrée.".
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks"
    Then I should see "Il n'y a pas encore de tâche enregistrée."

  Scenario: [Success] If I am connected and there are tasks, then I should see them.
    Given I load a user in database
    And I load tasks in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks"
    Then I should see "Une tâche"
    And I should see "Une autre tâche"

  Scenario: [Success] If I am connected and remove a task, then I should be redirected to the tasks list page.
    Given I load a user in database
    And I load a task in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks"
    And I follow "Supprimer"
    And I follow "Oui"
    Then I should be on "/tasks"
    And I should see "Superbe !"
    
  Scenario: [Success] If I am connected and click on the "Effectuée" link, then I should be redirected to the tasks list page.
    Given I load a user in database
    And I load a task in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks"
    And I follow "Effectuée"
    And I follow "Oui"
    Then I should be on "/tasks"
    And I should see "Superbe !"

  Scenario: [Success] If I am connected and click on the "Non effectuée" link, then I should be redirected to the tasks list page.
    Given I load a user in database
    And I load a performed task in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks"
    And I follow "Non effectuée"
    And I follow "Oui"
    Then I should be on "/tasks"
    And I should see "Superbe !"

  Scenario: [Success] If I am connected and click on the "Créer une tâche" link, then I should be redirected to the task creation page.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks"
    And I follow "Créer une tâche"
    Then I should be on "/tasks/create"

  Scenario: [Success] If I am connected and click on the "Créer un utilisateur" link, then I should be redirected to the user creation page.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks"
    And I follow "Créer un utilisateur"
    Then I should be on "/users/create"

  Scenario: [Success] If I am connected and click on the "Se déconnecter" link, then I should be redirected to the login page.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks"
    And I follow "Se déconnecter"
    Then I should be on "/login"
