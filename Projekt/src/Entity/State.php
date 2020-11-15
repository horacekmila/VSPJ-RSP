<?php

namespace App\Entity;

use App\Repository\StateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StateRepository::class)
 */
class State
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
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=StateGroup::class, inversedBy="previusStates")
     * @ORM\JoinTable("state_group", name="previous_states")
     */
    private $previousStateGroup;

    /**
     * @ORM\ManyToOne(targetEntity=StateGroup::class, inversedBy="nextStates")
     * @ORM\JoinTable("state_group", name="next_states")
     */
    private $nextStateGroup;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setPreviousStateGroup(?StateGroup $previousStateGroup): self
    {
        $this->previousStateGroup = $previousStateGroup;

        return $this;
    }

    public function setNextStateGroup(?StateGroup $nextStateGroup): self
    {
        $this->nextStateGroup = $nextStateGroup;

        return $this;
    }

    /**
     * @return StateGroup
     */
    public function getPreviousStateGroup(): StateGroup
    {
        return $this->previousStateGroup;
    }

    /**
     * @return StateGroup
     */
    public function getNextStateGroup(): StateGroup
    {
        return $this->nextStateGroup;
    }
}
