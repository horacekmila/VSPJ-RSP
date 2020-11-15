<?php

namespace App\Entity;

use App\Repository\StateGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StateGroupRepository::class)
 */
class StateGroup
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=State::class, mappedBy="previousStateGroup")
     */
    private $previusStates;

    /**
     * @ORM\ManyToMany(targetEntity=State::class, mappedBy="nextStateGroup")
     */
    private $nextStates;

    public function __construct()
    {
        $this->previusStates = new ArrayCollection();
        $this->nextStates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|State[]
     */
    public function getPreviusStates(): Collection
    {
        return $this->previusStates;
    }

    public function addPreviusState(State $previusState): self
    {
        if (!$this->previusStates->contains($previusState)) {
            $this->previusStates[] = $previusState;
            $previusState->setPreviousStateGroup($this);
        }

        return $this;
    }

    /**
     * @return Collection|State[]
     */
    public function getNextStates(): Collection
    {
        return $this->nextStates;
    }

    public function addNextState(State $nextState): self
    {
        if (!$this->nextStates->contains($nextState)) {
            $this->nextStates[] = $nextState;
            $nextState->setNextStateGroup($this);
        }

        return $this;
    }
}
