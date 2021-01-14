<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReviewRepository::class)
 */
class Review
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=ReviewCategory::class)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="review")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @ORM\Column(type="integer")
     */
    private $category_1_rating;

    /**
     * @ORM\Column(type="integer")
     */
    private $category_2_rating;

    /**
     * @ORM\Column(type="integer")
     */
    private $category_3_rating;

    /**
     * @ORM\Column(type="integer")
     */
    private $category_4_rating;

    /**
     * @ORM\Column(type="integer")
     */
    private $category_5_rating;

    public function __construct()
    {
        $this->category = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|ReviewCategory[]
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(ReviewCategory $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(ReviewCategory $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getCategory1Rating(): ?int
    {
        return $this->category_1_rating;
    }

    public function setCategory1Rating(int $category_1_rating): self
    {
        $this->category_1_rating = $category_1_rating;

        return $this;
    }

    public function getCategory2Rating(): ?int
    {
        return $this->category_2_rating;
    }

    public function setCategory2Rating(int $category_2_rating): self
    {
        $this->category_2_rating = $category_2_rating;

        return $this;
    }

    public function getCategory3Rating(): ?int
    {
        return $this->category_3_rating;
    }

    public function setCategory3Rating(int $category_3_rating): self
    {
        $this->category_3_rating = $category_3_rating;

        return $this;
    }

    public function getCategory4Rating(): ?int
    {
        return $this->category_4_rating;
    }

    public function setCategory4Rating(int $category_4_rating): self
    {
        $this->category_4_rating = $category_4_rating;

        return $this;
    }

    public function getCategory5Rating(): ?int
    {
        return $this->category_5_rating;
    }

    public function setCategory5Rating(int $category_5_rating): self
    {
        $this->category_5_rating = $category_5_rating;

        return $this;
    }
}
