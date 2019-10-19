Feature: As a connected user, I must be able to access the task creation page.

  Scenario: [Fail] If I am not connected, then I should be redirected to the login page.
    Given I am on "/tasks/create"
    Then I should be on "/login"

  Scenario: [Fail] If I am connected and submit the form without filling in the fields, then I should stay on the task creation page and I should see error messages.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks/create"
    And I press "Ajouter"
    Then I should be on "/tasks/create"
    And I should see "Vous devez saisir un titre."
    And I should see "Vous devez saisir du contenu."

  Scenario: [Fail] If I am connected and submit the form with only the task title, then I should stay on the task creation page and I should see an error message.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks/create"
    And I fill in "Le titre de la tâche" for "task_title"
    And I press "Ajouter"
    Then I should be on "/tasks/create"
    And I should see "Vous devez saisir du contenu."

  Scenario: [Fail] If I am connected and submit the form with only the task content, then I should stay on the task creation page and I should see an error message.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks/create"
    And I fill in "Coucou je suis le contenu d'une tâche !" for "task_content"
    And I press "Ajouter"
    Then I should be on "/tasks/create"
    And I should see "Vous devez saisir un titre."

  Scenario: [Fail] If I am connected and submit the form without respecting the minimal validation constraint, then I should stay on the task creation page and I should see error messages.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks/create"
    And I fill in the following:
        | task_title | Titr |
        | task_content | Coucou |
    And I press "Ajouter"
    Then I should be on "/tasks/create"
    And I should see "Le titre doit être composé de 5 caractères minimum."
    And I should see "Le contenu doit être composé de 10 caractères minimum."

  Scenario: [Fail] If I am connected and submit the form without respecting the maximal validation constraint, then I should stay on the task creation page and I should see error messages.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks/create"
    And I fill in the following:
        | task_title | Titreeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee |
        | task_content | Coucouuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuu |
    And I press "Ajouter"
    Then I should be on "/tasks/create"
    And I should see "Le titre doit être composé de 50 caractères maximum."
    And I should see "Le contenu doit être composé de 200 caractères maximum."

  Scenario: [Success] If I am connected, then I should be able to go to the task creation page.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks/create"
    Then I should be on "/tasks/create"

  Scenario: [Success] If I am connected and submit the form by filling in the fields, then I should stay on the task creation page and I should see "La tâche a été créée !".
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks/create"
    And I fill in the following:
        | task_title | Titre de la tâche |
        | task_content | Coucou je suis le contenu d'une tâche ! |
    And I press "Ajouter"
    Then I should be on "/tasks"
    And I should see "Superbe !"

  Scenario: [Success] If I am connected and click on the "Se déconnecter" link, then I should be redirected to the login page.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks/create"
    And I follow "Se déconnecter"
    Then I should be on "/login"

  Scenario: [Success] If I am connected and click on the "Créer un utilisateur" link, then I should be redirected to the user creation page.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks/create"
    And I follow "Créer un utilisateur"
    Then I should be on "/users/create"

  Scenario: [Success] If I am connected and click on the "Retour à la liste des tâches" link, then I should be redirected to the tasks list page.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/tasks/create"
    And I follow "Retour à la liste des tâches"
    Then I should be on "/tasks"