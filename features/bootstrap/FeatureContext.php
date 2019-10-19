<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AppBundle\Entity\User;
use AppBundle\Entity\Task;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context
{
    private $entityManager;
    private $passwordEncoder;
    private $user;
    private $task;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @BeforeScenario
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function initDatabase()
    {
        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->dropSchema($this->entityManager->getMetadataFactory()->getAllMetadata());
        $schemaTool->createSchema($this->entityManager->getMetadataFactory()->getAllMetadata());
    }

    /**
     * @Given I load a user in database
     */
    public function iLoadAUserInDatabase()
    {
        $this->user = new User();
        $this->user->setUsername("JohnDoe")
             ->setEmail('johndoe@doe.com')
             ->setPassword($this->passwordEncoder->encodePassword($this->user, '12345678'))
             ->setRoles(['ROLE_ADMIN']);
        

        $this->entityManager->persist($this->user);
        $this->entityManager->flush();
    }

    /**
     * @Given I load users in database
     */
    public function iLoadUsersInDatabase()
    {
        $this->user = new User();
        $this->user->setUsername("JohnDoe")
              ->setEmail("johndoe@doe.com")
              ->setPassword($this->passwordEncoder->encodePassword($this->user, '12345678'))
              ->setRoles(["ROLE_ADMIN"]);

        $user2 = new User();
        $user2->setUsername("JaneDoe")
              ->setEmail("janedoe@doe.com")
              ->setPassword($this->passwordEncoder->encodePassword($user2, '12345678'))
              ->setRoles(["ROLE_USER"]);

        $this->entityManager->persist($this->user);
        $this->entityManager->persist($user2);
        $this->entityManager->flush();
    }

    /**
     * @Given I load a task in database
     */
    public function iLoadATaskInDatabase()
    {
        $this->task = new Task(); 
        $this->task->setTitle("Une tâche")
             ->setContent("Contenu de la tâche")
             ->setAuthor($this->user);

        $this->entityManager->persist($this->task);
        $this->entityManager->flush();
    }

    /**
     * @Given I load a performed task in database
     */
    public function iLoadAPerformedTaskInDatabase()
    {
        $this->task = new Task(); 
        $this->task->setTitle("Une tâche")
             ->setContent("Contenu de la tâche")
             ->setAuthor($this->user)
             ->setDone(true);

        $this->entityManager->persist($this->task);
        $this->entityManager->flush();
    }

    /**
     * @Given I load tasks in database
     */
    public function iLoadTasksInDatabase()
    {
        $task1 = new Task();
        $task1->setTitle("Une tâche")
              ->setContent("Contenu de la tâche 1 !")
              ->setAuthor($this->user);

        $task2 = new Task();
        $task2->setTitle("Une autre tâche")
              ->setContent("Contenu de la tâche 2 !")
              ->setAuthor($this->user);

        $this->entityManager->persist($task1);
        $this->entityManager->persist($task2);
        $this->entityManager->flush();
    }

    /**
     * @Given I connect my self with username :username and password :password
     */
    public function iConnectMySelfWithUsernameAndPassword($username, $password)
    {
        $this->visit('/login');
        $this->fillField('username', $username);
        $this->fillField('password', $password);
        $this->pressButton('Se connecter');
    }
}
