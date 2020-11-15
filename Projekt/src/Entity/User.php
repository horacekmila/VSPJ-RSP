<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $middlename;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=ContentPage::class, mappedBy="author")
     */
    private $contentPages;

    /**
     * @ORM\ManyToMany(targetEntity=Role::class)
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="assigne")
     */
    private $assignedArticles;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="createdBy")
     */
    private $creater;

    /**
     * @ORM\OneToMany(targetEntity=IssueComment::class, mappedBy="author")
     */
    private $issueComments;

    /**
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="author")
     */
    private $questions;

    /**
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="author")
     */
    private $answers;

    public function __construct()
    {
        $this->contentPages = new ArrayCollection();
        $this->roles = new ArrayCollection();
        $this->assignedArticles = new ArrayCollection();
        $this->creater = new ArrayCollection();
        $this->issueComments = new ArrayCollection();
        $this->questions = new ArrayCollection();
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getMiddlename(): ?string
    {
        return $this->middlename;
    }

    public function setMiddlename(?string $middlename): self
    {
        $this->middlename = $middlename;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|ContentPage[]
     */
    public function getContentPages(): Collection
    {
        return $this->contentPages;
    }

    public function addContentPage(ContentPage $contentPage): self
    {
        if (!$this->contentPages->contains($contentPage)) {
            $this->contentPages[] = $contentPage;
            $contentPage->setAuthor($this);
        }

        return $this;
    }

    public function removeContentPage(ContentPage $contentPage): self
    {
        if ($this->contentPages->removeElement($contentPage)) {
            // set the owning side to null (unless already changed)
            if ($contentPage->getAuthor() === $this) {
                $contentPage->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles->map(function (Role $role){
            return $role->getName();
        })->toArray();
    }

    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        $this->roles->removeElement($role);

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getAssignedArticles(): Collection
    {
        return $this->assignedArticles;
    }

    public function addAssignedArticle(Article $assignedArticle): self
    {
        if (!$this->assignedArticles->contains($assignedArticle)) {
            $this->assignedArticles[] = $assignedArticle;
            $assignedArticle->setAssigne($this);
        }

        return $this;
    }

    public function removeAssignedArticle(Article $assignedArticle): self
    {
        if ($this->assignedArticles->removeElement($assignedArticle)) {
            // set the owning side to null (unless already changed)
            if ($assignedArticle->getAssigne() === $this) {
                $assignedArticle->setAssigne(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getCreater(): Collection
    {
        return $this->creater;
    }

    public function addCreater(Article $creater): self
    {
        if (!$this->creater->contains($creater)) {
            $this->creater[] = $creater;
            $creater->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreater(Article $creater): self
    {
        if ($this->creater->removeElement($creater)) {
            // set the owning side to null (unless already changed)
            if ($creater->getCreatedBy() === $this) {
                $creater->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|IssueComment[]
     */
    public function getIssueComments(): Collection
    {
        return $this->issueComments;
    }

    public function addIssueComment(IssueComment $issueComment): self
    {
        if (!$this->issueComments->contains($issueComment)) {
            $this->issueComments[] = $issueComment;
            $issueComment->setAuthor($this);
        }

        return $this;
    }

    public function removeIssueComment(IssueComment $issueComment): self
    {
        if ($this->issueComments->removeElement($issueComment)) {
            // set the owning side to null (unless already changed)
            if ($issueComment->getAuthor() === $this) {
                $issueComment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setAuthor($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getAuthor() === $this) {
                $question->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setAuthor($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getAuthor() === $this) {
                $answer->setAuthor(null);
            }
        }

        return $this;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        return $this->getFirstname() . " " .$this->getLastname();
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->setCreatedAt(new \DateTime("now"));
    }

    /**
     * Gets triggered every time on update

     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->setUpdatedAt(new \DateTime("now"));
    }
}
