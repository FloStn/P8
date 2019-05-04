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
        $this->user->setUsername("JohnDoe");
        $this->user->setEmail("johndoe@doe.com");
        $this->user->setPassword($this->passwordEncoder->encodePassword($this->user, '12345678'));

        $this->entityManager->persist($this->user);
        $this->entityManager->flush();
    }

    /**
     * @Given I load users in database
     */
    public function iLoadUsersInDatabase()
    {
        $this->user1 = new User();
        $this->user1->setUsername("JohnDoe");
        $this->user1->setEmail("johndoe@doe.com");
        $this->user1->setPassword($this->passwordEncoder->encodePassword($this->user1, '12345678'));

        $this->user2 = new User();
        $this->user2->setUsername("JaneDoe");
        $this->user2->setEmail("janedoe@doe.com");
        $this->user2->setPassword($this->passwordEncoder->encodePassword($this->user2, '12345678'));

        $this->entityManager->persist($this->user1);
        $this->entityManager->persist($this->user2);
        $this->entityManager->flush();
    }

    /**
     * @Given I load a task in database
     */
    public function iLoadATaskInDatabase()
    {
        $this->task = new Task();
        $this->task->setTitle("Une tâche");
        $this->task->setContent("Contenu de la tâche");

        $this->entityManager->persist($this->task);
        $this->entityManager->flush();
    }

    /**
     * @Given I load tasks in database
     */
    public function iLoadTasksInDatabase()
    {
        $this->task1 = new Task();
        $this->task1->setTitle("Une tâche");
        $this->task1->setContent("Contenu de la tâche 1 !");

        $this->task2 = new Task();
        $this->task2->setTitle("Une autre tâche");
        $this->task2->setContent("Contenu de la tâche 2 !");

        $this->entityManager->persist($this->task1);
        $this->entityManager->persist($this->task2);
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
