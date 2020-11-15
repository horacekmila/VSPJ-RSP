<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $Content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $docxFilename;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pdfFilename;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="integer")
     */
    private $version;

    /**
     * @ORM\Column(type="boolean")
     */
    private $editable;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="assignedArticles")
     */
    private $assigne;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="creater")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="article")
     */
    private $review;

    /**
     * @ORM\ManyToMany(targetEntity=Magazine::class, inversedBy="articles")
     */
    private $magazine;

    /**
     * @ORM\ManyToOne(targetEntity=State::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $state;


    public function __construct()
    {
        $this->review = new ArrayCollection();
        $this->magazine = new ArrayCollection();
        $this->state = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(string $Content): self
    {
        $this->Content = $Content;

        return $this;
    }

    public function getDocxFilename(): ?string
    {
        return $this->docxFilename;
    }

    public function setDocxFilename(?string $docxFilename): self
    {
        $this->docxFilename = $docxFilename;

        return $this;
    }

    public function getPdfFilename(): ?string
    {
        return $this->pdfFilename;
    }

    public function setPdfFilename(?string $pdfFilename): self
    {
        $this->pdfFilename = $pdfFilename;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setVersion(int $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getEditable(): ?bool
    {
        return $this->editable;
    }

    public function setEditable(bool $editable): self
    {
        $this->editable = $editable;

        return $this;
    }

    public function getAssigne(): ?User
    {
        return $this->assigne;
    }

    public function setAssigne(?User $assigne): self
    {
        $this->assigne = $assigne;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReview(): Collection
    {
        return $this->review;
    }

    public function addReview(Review $review): self
    {
        if (!$this->review->contains($review)) {
            $this->review[] = $review;
            $review->setArticle($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->review->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getArticle() === $this) {
                $review->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Magazine[]
     */
    public function getMagazine(): Collection
    {
        return $this->magazine;
    }

    public function addMagazine(Magazine $magazine): self
    {
        if (!$this->magazine->contains($magazine)) {
            $this->magazine[] = $magazine;
        }

        return $this;
    }

    public function removeMagazine(Magazine $magazine): self
    {
        $this->magazine->removeElement($magazine);

        return $this;
    }

    /**
     * @return Collection|State[]
     */
    public function getState(): Collection
    {
        return $this->state;
    }

    public function addState(State $state): self
    {
        if (!$this->state->contains($state)) {
            $this->state[] = $state;
            $state->setArticle($this);
        }

        return $this;
    }

    public function removeState(State $state): self
    {
        if ($this->state->removeElement($state)) {
            // set the owning side to null (unless already changed)
            if ($state->getArticle() === $this) {
                $state->setArticle(null);
            }
        }

        return $this;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }
}
