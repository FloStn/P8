<?php

namespace Tests\AppBundle\Repository;

use AppBundle\Entity\User;
use AppBundle\Repository\TaskRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use PHPUnit\Framework\TestCase;

class TaskRepositoryTest extends TestCase
{
    /**
     * @var TaskRepository
     */
    private $taskRepository;

    public function setUp()
    {
        $configuration = $this->createMock(Configuration::class);
        $configuration->method("getDefaultQueryHints")->willReturn([]);

        $queryBuilder = $this->createMock(QueryBuilder::class);
        $queryBuilder->method("select")->willReturnSelf();
        $queryBuilder->method("from")->willReturnSelf();
        $queryBuilder->method("andWhere")->willReturnSelf();
        $queryBuilder->method("setParameter")->willReturnSelf();
        $queryBuilder->method("orderBy")->willReturnSelf();
        $queryBuilder->method("setMaxResults")->willReturnSelf();

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->method("getConfiguration")->willReturn($configuration);
        $entityManager->method("createQueryBuilder")->willReturn($queryBuilder);

        $query = new class($entityManager) extends AbstractQuery {
            public function getSQL()
            {
                return "";
            }

            public function execute($parameters = null, $hydrationMode = null)
            {
                return ["toto"];
            }

            protected function _doExecute()
            {

            }
        };

        $queryBuilder->method("getQuery")->willReturn($query);

        $metadata = $this->createMock(ClassMetadata::class);

        $this->taskRepository = new TaskRepository(
            $entityManager,
            $metadata
        );
    }

    public function testFindByAuthorField()
    {
        $this->assertEquals(["toto"], $this->taskRepository->findByAuthorField(new User()));
    }
}