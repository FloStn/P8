Feature: As a connected user, I must be able to access the user creation page.

  Scenario: [Fail] If I am not connected, then I should be redirected to the login page.
    Given I am on "/users/create"
    Then I should be on "/login"

  Scenario: [Fail] If I am connected and submit the form without filling in the fields, then I should stay on the user creation page and I should see an error message.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/users/create"
    And I press "Ajouter"
    Then I should be on "/users/create"
    And I should see "Vous devez saisir un nom d'utilisateur."
    And I should see "Vous devez saisir une adresse email."

  Scenario: [Fail] If I am connected and submit the form without respecting the minimal validation constraint, then I should stay on the user creation page and I should see error messages.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/users/create"
    And I fill in the following:
        | user_username | Ja |
        | user_password_first | 12345678 |
        | user_password_second | 12345678 |
        | user_email | j@d.com |
    And I press "Ajouter"
    Then I should be on "/users/create"
    And I should see "Le nom d'utilisateur doit être composé de 5 caractères minimum."
    And I should see "L'email doit être composé de 8 caractères minimum."

  Scenario: [Fail] If I am connected and submit the form without respecting the maximal validation constraint, then I should stay on the user creation page and I should see error messages.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/users/create"
    And I fill in the following:
        | user_username | Janeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee |
        | user_password_first | 12345678 |
        | user_password_second | 12345678 |
        | user_email | janeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee@doeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee.com |
    And I press "Ajouter"
    Then I should be on "/users/create"
    And I should see "Le nom d'utilisateur doit être composé de 30 caractères maximum."
    And I should see "L'email doit être composé de 60 caractères maximum."

  Scenario: [Success] If I am connected, then I can access the user creation page.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/users/create"
    Then I should be on "/users/create"

  Scenario: [Success] If I am connected and submit the form by filling in all the fields, then I am redirected to the user creation page and I should see "L'utilisateur a été créé !".
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/users/create"
    And I fill in the following:
        | user_username | JaneDoe |
        | user_password_first | 12345678 |
        | user_password_second | 12345678 |
        | user_email | janedoe@doe.com |
    And I press "Ajouter"
    Then I should be on "/users"
    And I should see "Superbe !"

  Scenario: [Success] If I am connected and click on the "Créer un utilisateur" link, then I should be redirected to the user creation page.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/users/create"
    And I follow "Créer un utilisateur"
    Then I should be on "/users/create"

  Scenario: [Success] If I am connected and click on the "Se déconnecter" link, then I should be redirected to the login page.
    Given I load a user in database
    And I connect my self with username "JohnDoe" and password "12345678"
    And I am on "/users/create"
    And I follow "Se déconnecter"
    Then I should be on "/login"