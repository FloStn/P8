<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

/**
 * @ORM\Table("task")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TaskRepository")
 * @ORM\EntityListeners({"AppBundle\Service\TaskListener"})
 */
class Task
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Vous devez saisir un titre.")
     * @Assert\Length(
     *       min = 5,
     *       max = 50,
     *       minMessage = "Le titre doit être composé de {{ limit }} caractères minimum.",
     *       maxMessage = "Le titre doit être composé de {{ limit }} caractères maximum.")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Vous devez saisir du contenu.")
     * @Assert\Length(
     *       min = 10,
     *       max = 200,
     *       minMessage = "Le contenu doit être composé de {{ limit }} caractères minimum.",
     *       maxMessage = "Le contenu doit être composé de {{ limit }} caractères maximum.")
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $done;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $author;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->done = false;
    }

    /**
     * Return task id
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Return task creation date
     *
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     *
     * @return Task
     */
    public function setCreatedAt(DateTime $createdAt): Task
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Return task title
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Task
     */
    public function setTitle(string $title): Task
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Return content task
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return Task
     */
    public function setContent(string $content): Task
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Return true if is done, else false
     *
     * @return boolean
     */
    public function isDone(): bool
    {
        return $this->done;
    }

    /**
     * @param boolean $flag
     *
     * @return Task
     */
    public function setDone(bool $flag): Task
    {
        $this->done = $flag;

        return $this;
    }

    /**
     * Return task author
     *
     * @return null|User
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * @param User $user
     *
     * @return Task
     */
    public function setAuthor(User $user): Task
    {
        $this->author = $user;

        return $this;
    }
}
