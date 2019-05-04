Feature: As a connected user, I must be able to access the task edit page.

  Scenario: [Fail] If I am not connected, then I should be redirected to the login page.
    Given I am on "/tasks/1/edit"
    Then I should be on "/login"

  Scenario: [Fail] If I am connected and ask to see a task that doesn't exist, then I should be redirected to the home page.
    Given I load a user in database
    And I load a task in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks/100/edit"
    Then I should be on "/"

  Scenario: [Fail] If I am connected and submit the edit form without filling in the fields, then I should stay on the edit page and I should see error messages.
    Given I load a user in database
    And I load a task in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks/1/edit"
    And I fill in the following:
        | task_title |  |
        | task_content |  |
    And I press "Modifier"
    Then I should be on "/tasks/1/edit"
    And I should see "Vous devez indiquer un titre."
    And I should see "Vous devez indiquer un contenu."

  Scenario: [Fail] If I am connected and submit the form without respecting the validation constraints, then I should stay on the edit page and I should see error messages.
    Given I load a user in database
    And I load a task in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks/1/edit"
    And I fill in the following:
        | task_title | Titr |
        | task_content | Coucou |
    And I press "Modifier"
    Then I should be on "/tasks/1/edit"
    And I should see "Le titre doit être composé de 5 caractères minimum."
    And I should see "Le contenu doit être composé de 10 caractères minimum."

  Scenario: [Success] If I am connected and submit the edit form by filling in all the fields, then I am redirected to the task list and I should see "La tâche a bien été modifiée !".
    Given I load a user in database
    And I load a task in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks/1/edit"
    And I fill in the following:
        | task_title | Nouveau titre |
        | task_content | Coucou je suis le nouveau contenu d'une tâche ! |
    And I press "Modifier"
    Then I should be on "/tasks"
    And I should see "La tâche a bien été modifiée !"

  Scenario: [Success] If I am connected and click on the "Créer un utilisateur" link, then I should be redirected to the user creation page.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks/1/edit"
    And I follow "Créer un utilisateur"
    Then I should be on "/users/create"

  Scenario: [Success] If I am connected and click on the "Se déconnecter" link, then I should be redirected to the login page.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks/1/edit"
    And I follow "Se déconnecter"
    Then I should be on "/login"